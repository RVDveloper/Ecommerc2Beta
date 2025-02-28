let stripe;

// Inicializar Stripe con la clave de prueba
if (typeof Stripe === 'undefined') {
  console.error("Stripe.js no está cargado correctamente.");
} else {
  stripe = Stripe('pk_test_51QsQLfLXZjkx9hbvBM02Z04TUmcNuQ2aXeFpMlHIACg78pqF9ATG4DrwcmSOufZu0ATpgARqxbFtfJqR6fkMPGf300J4EEcRrP');
}

// Inicializar el carrito cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", function () {
  console.log("Inicializando carrito...");
  renderCart();
  setupHeaderCart();
  
  // Añadir información sobre tarjetas de prueba
  const cartSummary = document.getElementById("cart-summary");
  if (cartSummary) {
    const testCardInfo = document.createElement('div');
    testCardInfo.className = 'test-card-info';
    testCardInfo.innerHTML = `
      <div style="margin-top: 20px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
        <h4 style="color: #6772e5; margin-bottom: 10px;">🛈 Información para Pruebas</h4>
        <p>Usar estas tarjetas de prueba para simular diferentes escenarios:</p>
        <ul style="list-style: none; padding-left: 0;">
          <li>💳 Pago exitoso: 4242 4242 4242 4242</li>
          <li>💳 Pago fallido: 4000 0000 0000 0002</li>
          <li>📅 Cualquier fecha futura</li>
          <li>🔒 Cualquier CVC de 3 dígitos</li>
        </ul>
      </div>
    `;
    cartSummary.appendChild(testCardInfo);
  }
});

// Calcular el total del carrito
function calculateTotal(cart) {
  return cart.reduce((total, item) => {
    return total + (item.price * item.quantity);
  }, 0);
}

// Actualizar el contador de productos en el header
function setupHeaderCart() {
  const cartCount = document.querySelector(".cart-count");
  if (cartCount) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
  }
}

// Renderizar el carrito en la tabla
function renderCart() {
  const cartTableBody = document.getElementById('cart-table-body');
  let cart = [];
  try {
    const cartData = localStorage.getItem('cart');
    cart = cartData ? JSON.parse(cartData) : [];
  } catch (error) {
    console.error('Error al cargar el carrito:', error);
    cart = [];
  }

  cartTableBody.innerHTML = '';
  let totalGeneral = 0;

  if (!cart || cart.length === 0) {
    cartTableBody.innerHTML = `
      <tr>
        <td colspan="6" class="empty-cart-message">
          <div class="empty-cart">
            <p>Tu carrito está vacío</p>
            <a href="menu.php" class="btn-continue-shopping">Continuar Comprando</a>
          </div>
        </td>
      </tr>
    `;
    return;
  }

  for (let i = 0; i < cart.length; i++) {
    const product = cart[i];
    if (!product || typeof product !== 'object') continue;

    const name = product.name || 'Producto sin nombre';
    const price = typeof product.price === 'number' ? product.price : 0;
    const quantity = typeof product.quantity === 'number' ? product.quantity : 1;
    const image = product.image || 'img-optimizado/default.jpg';
    
    const subtotal = price * quantity;
    totalGeneral += subtotal;

    const row = document.createElement('tr');
    row.innerHTML = `
      <td class="product-image">
        <img src="${image}" 
             alt="${name}" 
             style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;"
             onerror="this.src='img-optimizado/default.jpg'">
      </td>
      <td class="product-name">${name}</td>
      <td class="product-price">${price.toFixed(2)} €</td>
      <td class="product-quantity">
        <div class="quantity-controls">
          <button class="quantity-btn minus" data-index="${i}">-</button>
          <input type="number" 
                 value="${quantity}" 
                 min="1" 
                 data-index="${i}" 
                 class="quantity-input"
                 style="width: 60px; text-align: center;">
          <button class="quantity-btn plus" data-index="${i}">+</button>
        </div>
      </td>
      <td class="product-total">${subtotal.toFixed(2)} €</td>
      <td class="product-actions">
        <button class="remove-item" data-index="${i}" 
                style="background-color: #ff4444; color: white; border: none; 
                       padding: 5px 10px; border-radius: 4px; cursor: pointer;">
          X
        </button>
      </td>
    `;
    cartTableBody.appendChild(row);
  }

  const totalRow = document.createElement('tr');
  totalRow.innerHTML = `
    <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
    <td colspan="2" style="font-weight: bold;">${totalGeneral.toFixed(2)} €</td>
  `;
  cartTableBody.appendChild(totalRow);

  updateCartSummary(totalGeneral);
  setupEventListeners();
}

// Actualizar el resumen del carrito
function updateCartSummary(subtotal) {
  const summaryHtml = `
    <div class="cart-summary">
      <h3>Resumen del Pedido</h3>
      <div class="summary-item">
        <span>Subtotal:</span>
        <span>${subtotal.toFixed(2)} €</span>
      </div>
      <div class="summary-item">
        <span>IVA (21%):</span>
        <span>${(subtotal * 0.21).toFixed(2)} €</span>
      </div>
      <div class="summary-item total">
        <span>Total:</span>
        <span>${(subtotal * 1.21).toFixed(2)} €</span>
      </div>
    </div>
  `;

  const summaryContainer = document.getElementById("cart-summary");
  if (summaryContainer) {
    summaryContainer.innerHTML = summaryHtml;
  }
}

// Configurar los event listeners para los botones del carrito
function setupEventListeners() {
  document.querySelectorAll(".quantity-btn").forEach((btn) => {
    btn.addEventListener("click", handleQuantityButton);
  });

  document.querySelectorAll(".quantity-input").forEach((input) => {
    input.addEventListener("change", updateQuantity);
    input.addEventListener("input", validateQuantityInput);
  });

  document.querySelectorAll(".remove-item").forEach((button) => {
    button.addEventListener("click", removeItem);
  });

  const clearCartBtn = document.getElementById("clear-cart");
  if (clearCartBtn) {
    clearCartBtn.addEventListener("click", clearCart);
  }

  const checkoutBtn = document.getElementById("checkout");
  if (checkoutBtn) {
    checkoutBtn.addEventListener("click", proceedToCheckout);
  }
}

// Manejar los botones de cantidad (+/-)
function handleQuantityButton(event) {
  const btn = event.currentTarget;
  const index = parseInt(btn.getAttribute("data-index"));
  const input = document.querySelector(`.quantity-input[data-index="${index}"]`);
  let value = parseInt(input.value);

  if (btn.classList.contains("minus")) {
    value = Math.max(1, value - 1);
  } else {
    value = Math.min(99, value + 1);
  }

  input.value = value;
  updateQuantity({ target: input });
}

// Validar la entrada de cantidad
function validateQuantityInput(event) {
  const input = event.target;
  let value = input.value.replace(/[^0-9]/g, "");
  value = Math.min(99, Math.max(1, value || 1));
  input.value = value;
}

// Actualizar la cantidad de un producto en el carrito
function updateQuantity(event) {
  const index = parseInt(event.target.getAttribute("data-index"));
  let newQuantity = parseInt(event.target.value);

  if (isNaN(newQuantity) || newQuantity < 1) {
    newQuantity = 1;
    event.target.value = 1;
  }

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  if (cart[index]) {
    cart[index].quantity = newQuantity;
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCart();
  }
}

// Eliminar un producto del carrito
function removeItem(event) {
  const index = parseInt(event.target.getAttribute("data-index"));
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCart();
  }
}

// Vaciar el carrito
function clearCart() {
  if (confirm("¿Estás seguro de que quieres vaciar el carrito?")) {
    localStorage.removeItem("cart");
    renderCart();
  }
}

// Procesar el pago
async function proceedToCheckout() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  if (cart.length === 0) {
    alert("Tu carrito está vacío");
    return;
  }

  try {
    console.log("Verificando stock...");
    const stockResponse = await fetch("check_stock.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ cart: cart }),
    });
    
    if (!stockResponse.ok) {
      throw new Error(`HTTP error! status: ${stockResponse.status}`);
    }
    
    const stockData = await stockResponse.json();
    console.log("Respuesta de stock:", stockData);

    if (!stockData.success) {
      if (stockData.errors && stockData.errors.length > 0) {
        alert(stockData.errors.join('\n'));
      } else {
        alert("Algunos productos no tienen stock suficiente");
      }
      return;
    }

    console.log("Procesando pago de prueba...");
    const stripeResponse = await fetch("process_payment.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        cart: cart,
        total: calculateTotal(cart)
      }),
    });

    if (!stripeResponse.ok) {
      const errorData = await stripeResponse.json();
      throw new Error(errorData.error?.message || `HTTP error! status: ${stripeResponse.status}`);
    }

    const session = await stripeResponse.json();
    console.log("Respuesta de Stripe:", session);

    if (session.error) {
      throw new Error(session.error.message);
    }

    if (!session.id) {
      throw new Error("No se recibió un ID de sesión válido de Stripe");
    }

    console.log("Redirigiendo al checkout de prueba...");
    const result = await stripe.redirectToCheckout({ sessionId: session.id });

    if (result.error) {
      throw new Error(result.error.message);
    }
    
  } catch (error) {
    console.error("Error:", error);
    const paymentError = document.getElementById('payment-error');
    if (paymentError) {
      paymentError.textContent = `Error al procesar el pedido: ${error.message}`;
      paymentError.style.display = 'block';
    } else {
      alert(`Error al procesar el pedido: ${error.message}`);
    }
  }  
}