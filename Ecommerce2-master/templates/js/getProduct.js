window.onload = () => {
  const cards = document.querySelectorAll(".card-main");
  const popup = document.getElementById("popup");
  const addToCartBtn = document.getElementById("add-to-cart");
  const cancelBtn = document.getElementById("cancel");

  let selectedProduct = null;

  cards.forEach((card) => {
    card.addEventListener("click", () => {
      selectedProduct = card;
      popup.style.display = "flex";
      popup.style.justifyContent = "center";
      popup.style.alignItems = "center";
      popup.style.flexDirection = "column";
    });
  });

  addToCartBtn.addEventListener("click", () => {
    if (selectedProduct) {
      const productId = selectedProduct.getAttribute("data-id");
      const titleElement = selectedProduct.querySelector("h2");
      const productName = titleElement
        ? titleElement.textContent.trim()
        : "Producto sin nombre";
      const productPrice = parseFloat(
        selectedProduct.getAttribute("data-price")
      );
      const productImage = validateImageUrl(selectedProduct.getAttribute("data-image"));

      // Validar datos antes de agregar al carrito
      if (!productId || isNaN(productPrice)) {
        alert("Error: Datos del producto inválidos");
        return;
      }

      let cart = [];
      try {
        const cartData = localStorage.getItem("cart");
        cart = cartData ? JSON.parse(cartData) : [];
        
        // Asegurarse de que cart sea un array
        if (!Array.isArray(cart)) {
          cart = [];
        }
      } catch (error) {
        console.error("Error al cargar el carrito:", error);
        cart = [];
      }

      // Verificar si el producto ya está en el carrito
      const existingProductIndex = cart.findIndex(
        (item) => item.id === productId
      );

      if (existingProductIndex !== -1) {
        // Si existe, incrementar cantidad
        cart[existingProductIndex].quantity += 1;
      } else {
        // Si no existe, agregar nuevo producto
        cart.push({
          id: productId,
          name: productName,
          price: productPrice,
          image: productImage,
          quantity: 1,
        });
      }

      try {
        localStorage.setItem("cart", JSON.stringify(cart));
        alert(`Producto ${productName} agregado al carrito`);
        
        // Actualizar el contador del carrito si existe
        const cartCount = document.querySelector(".cart-count");
        if (cartCount) {
          const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
          cartCount.textContent = totalItems;
        }
      } catch (error) {
        console.error("Error al guardar el carrito:", error);
        alert("Error al guardar el producto en el carrito");
      }

      popup.style.display = "none";
    }
  });

  cancelBtn.addEventListener("click", () => {
    popup.style.display = "none";
  });
};

function validateImageUrl(url) {
  if (!url || url === "undefined" || url === "null") {
    return "img-optimizado/default.jpg";
  }
  
  // Limpiar la URL
  url = url.trim();
  
  // Si la URL ya es absoluta, devuélvela
  if (url.startsWith("http://") || url.startsWith("https://")) {
    return url;
  }
  
  // Si la URL ya tiene la estructura correcta, devuélvela
  if (url.startsWith("img-optimizado/")) {
    return url;
  }
  
  // Si es una ruta relativa, añade el prefijo correcto
  return `img-optimizado/${url.replace(/^[./]+/, '')}`;
}

// Función auxiliar para validar el carrito
function validateCart(cart) {
  if (!Array.isArray(cart)) {
    return false;
  }

  return cart.every(item => {
    return (
      item &&
      typeof item === 'object' &&
      typeof item.id !== 'undefined' &&
      typeof item.name === 'string' &&
      typeof item.price === 'number' &&
      !isNaN(item.price) &&
      typeof item.quantity === 'number' &&
      !isNaN(item.quantity) &&
      item.quantity > 0
    );
  });
}

// Función para añadir productos al carrito
function addToCart(product) {
    try {
        // Validar el producto antes de agregarlo
        if (!product || typeof product !== 'object') {
            throw new Error('Producto inválido');
        }

        // Asegurarse de que todos los campos necesarios existan
        const newItem = {
            id: product.id || Date.now().toString(),
            name: product.name || 'Producto sin nombre',
            price: parseFloat(product.price) || 0,
            quantity: 1,
            image: validateImageUrl(product.image)
        };

        let cart = [];
        try {
            const cartData = localStorage.getItem('cart');
            cart = cartData ? JSON.parse(cartData) : [];
            
            // Asegurarse de que cart sea un array
            if (!Array.isArray(cart)) {
                cart = [];
            }
        } catch (error) {
            console.error('Error al cargar el carrito:', error);
            cart = [];
        }

        // Verificar si el producto ya existe
        const existingIndex = cart.findIndex(item => item.id === newItem.id);
        if (existingIndex !== -1) {
            cart[existingIndex].quantity += 1;
        } else {
            cart.push(newItem);
        }

        // Validar el carrito antes de guardarlo
        if (!validateCart(cart)) {
            throw new Error('Carrito inválido');
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        console.log('Producto agregado:', newItem);
        
        // Actualizar el contador del carrito si existe
        const cartCount = document.querySelector(".cart-count");
        if (cartCount) {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
        }

        return true;
    } catch (error) {
        console.error('Error al agregar al carrito:', error);
        alert('Error al agregar el producto al carrito');
        return false;
    }
}
