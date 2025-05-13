<<<<<<< HEAD
document.querySelectorAll('#category-buttons button').forEach(btn => {
    btn.addEventListener('click', function () {
        const categoria = this.dataset.cat;

        document.querySelectorAll('#category-buttons button').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        fetch('../Controller/LibroController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'categoria=' + encodeURIComponent(categoria)
        })
        .then(response => response.json())
        .then(data => {
            const bookList = document.getElementById('book-list');
            bookList.innerHTML = '';

            if (data.length === 0) {
                bookList.innerHTML = '<p>No hay libros en esta categoría.</p>';
                return;
            }

            data.forEach(libro => {
                const card = `
                <div class="col-md-4 mb-4">
                    <div class="card h-100 animate-card">
                        <img src="../${libro.imagen}" class="card-img-top book-img" alt="Imagen del libro">
                        <div class="card-body">
                            <h5 class="card-title">${libro.titulo}</h5>
                            <p class="card-text"><strong>Categoría:</strong> ${libro.categoria}</p>
                            <p class="card-text"><strong>Precio:</strong> $${parseFloat(libro.precio).toFixed(2)}</p>
                            <p class="card-text"><strong>Descripción:</strong> ${libro.descripcion}</p>
                            <p class="card-text"><strong>Disponible:</strong> ${libro.cantidad} unidades</p>
                            <p class="card-text"><strong>Ventas:</strong> ${libro.ventas} vendidos</p>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary agregar-carrito" 
                                    data-id="${libro.id}" 
                                    data-titulo="${libro.titulo}" 
                                    data-precio="${libro.precio}" 
                                    data-cantidad="${libro.cantidad}">
                                Agregar al carrito
                            </button>
                        </div>
                    </div>
                </div>`;
                bookList.innerHTML += card;
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchBtn = document.getElementById("searchBtn");
    const bookList = document.getElementById("book-list");

    searchBtn.addEventListener("click", function () {
        const titulo = searchInput.value.trim();
        if (titulo === "") return;

        const formData = new FormData();
        formData.append("titulo", titulo);

        fetch("../View/buscarLibro.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            bookList.innerHTML = data;
        })
        .catch(error => {
            console.error("Error en la búsqueda:", error);
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    let cart = [];

    // Cargar carrito desde localStorage
    if (localStorage.getItem('cart')) {
        cart = JSON.parse(localStorage.getItem('cart'));
    }

    const cartList = document.getElementById('cart-list');
    const cartTotal = document.getElementById('cart-total');
    const offcanvasElement = document.getElementById('offcanvasCart');
    const offcanvasCart = new bootstrap.Offcanvas(offcanvasElement);

    // Evento para agregar libros al carrito
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('agregar-carrito')) {
            const button = e.target;
            const id = button.getAttribute('data-id');
            const titulo = button.getAttribute('data-titulo');
            const precio = parseFloat(button.getAttribute('data-precio'));

            const existente = cart.find(item => item.id === id);
            if (existente) {
                existente.cantidad++;
            } else {
                cart.push({ id, titulo, precio, cantidad: 1 });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            actualizarCarrito();
            offcanvasCart.show();
        }
    });

    // Función para vaciar el carrito
    function vaciarCarrito() {
        cart = [];
        localStorage.removeItem('cart');
        actualizarCarrito();
    }

    // Evento para vaciar carrito
    document.getElementById('vaciar-carrito-btn').addEventListener('click', function () {
        if (confirm('¿Estás seguro que deseas vaciar el carrito?')) {
            vaciarCarrito();
        }
    });

    // Función para actualizar el DOM del carrito
    function actualizarCarrito() {
        cartList.innerHTML = '';
        let total = 0;

        cart.forEach(item => {
            total += item.precio * item.cantidad;
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                ${item.titulo}
                <span class="badge bg-primary rounded-pill">${item.cantidad} x $${item.precio.toFixed(2)}</span>
            `;
            cartList.appendChild(li);
        });

        cartTotal.textContent = total.toFixed(2);
    }

    // Evento para finalizar compra
    document.getElementById('checkout-btn').addEventListener('click', function () {
        fetch('../Controller/procesar_venta.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("¡Compra realizada exitosamente!");
                cart = [];
                localStorage.removeItem('cart');
                actualizarCarrito();
            } else {
                alert("Hubo un error al procesar la compra.");
            }
        })
        .catch(error => {
            console.error('Error en la compra:', error);
            alert("Error en la conexión con el servidor.");
        });
    });

    actualizarCarrito();
});

function filtrarCategoria(categoria) {
    const cards = document.querySelectorAll('#book-list .card');

    cards.forEach(card => {
        const categoriaTexto = card.querySelector('.card-text strong')?.nextSibling?.textContent?.trim();
        if (categoria === 'Todos' || categoriaTexto === categoria) {
            card.parentElement.style.display = 'block';
        } else {
            card.parentElement.style.display = 'none';
        }
    });
}

// Eliminar libro del localStorage (si lo usas)
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('btn-eliminar')) {
        const idLibro = event.target.getAttribute('data-id');
        const librosGuardados = JSON.parse(localStorage.getItem('libros')) || [];
        const librosActualizados = librosGuardados.filter(libro => libro.id !== idLibro);
        localStorage.setItem('libros', JSON.stringify(librosActualizados));
        event.target.closest('.libro-item')?.remove();
        alert('Libro eliminado correctamente');
    }
});
=======
document.querySelectorAll('#category-buttons button').forEach(btn => {
    btn.addEventListener('click', function () {
        const categoria = this.dataset.cat;

        // Quitar clase 'active' de todos y agregar solo al clickeado
        document.querySelectorAll('#category-buttons button').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        fetch('../Controller/LibroController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'categoria=' + encodeURIComponent(categoria)
        })
        .then(response => response.json())
        .then(data => {
            const bookList = document.getElementById('book-list');
            bookList.innerHTML = '';

            if (data.length === 0) {
                bookList.innerHTML = '<p>No hay libros en esta categoría.</p>';
                return;
            }

            data.forEach(libro => {
                const card = `
                <div class="col-md-4 mb-4">
                    <div class="card h-100 animate-card">
                        <img src="../${libro.imagen}" class="card-img-top book-img" alt="Imagen del libro">
                        <div class="card-body">
                            <h5 class="card-title">${libro.titulo}</h5>
                            <p class="card-text"><strong>Categoría:</strong> ${libro.categoria}</p>
                            <p class="card-text"><strong>Precio:</strong> $${parseFloat(libro.precio).toFixed(2)}</p>
                            <p class="card-text"><strong>Descripción:</strong> ${libro.descripcion}</p>
                            <p class="card-text"><strong>Disponible:</strong> ${libro.cantidad} unidades</p>
                            <p class="card-text"><strong>Ventas:</strong> ${libro.ventas} vendidos</p>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary">Agregar al carrito</button>
                        </div>
                    </div>
                </div>`;
                bookList.innerHTML += card;
            });
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchBtn = document.getElementById("searchBtn");
    const bookList = document.getElementById("book-list");

    searchBtn.addEventListener("click", function () {
        const titulo = searchInput.value.trim();

        if (titulo === "") return;

        const formData = new FormData();
        formData.append("titulo", titulo);

        fetch("../View/buscarLibro.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            bookList.innerHTML = data;
        })
        .catch(error => {
            console.error("Error en la búsqueda:", error);
        });
    });
});
// Código para manejar el carrito y la finalización de compra
document.addEventListener('DOMContentLoaded', function () {
    let cart = [];

    // Cargar carrito desde localStorage
    if (localStorage.getItem('cart')) {
        cart = JSON.parse(localStorage.getItem('cart'));
    }

    const cartList = document.getElementById('cart-list');
    const cartTotal = document.getElementById('cart-total');
    const offcanvasElement = document.getElementById('offcanvasCart');
    const offcanvasCart = new bootstrap.Offcanvas(offcanvasElement);

    // Agregar libros al carrito
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('agregar-carrito')) {
            const button = e.target;
            const id = button.getAttribute('data-id');
            const titulo = button.getAttribute('data-titulo');
            const precio = parseFloat(button.getAttribute('data-precio'));
            const cantidad = parseInt(button.getAttribute('data-cantidad'));

            const existente = cart.find(item => item.id === id);
            if (existente) {
                existente.cantidad++;
            } else {
                cart.push({ id, titulo, precio, cantidad: 1 });
            }

            // Guardar carrito en localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            actualizarCarrito();
            offcanvasCart.show(); // Muestra el offcanvas "Ver carrito"
        }
    });

    // Función para actualizar el carrito
    function actualizarCarrito() {
        cartList.innerHTML = '';
        let total = 0;

        cart.forEach(item => {
            total += item.precio * item.cantidad;
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                ${item.titulo}
                <span class="badge bg-primary rounded-pill">${item.cantidad} x $${item.precio.toFixed(2)}</span>
            `;
            cartList.appendChild(li);
        });

        cartTotal.textContent = total.toFixed(2);
    }

    // Finalizar compra usando fetch
    document.getElementById('checkout-btn').addEventListener('click', function () {
        fetch('../Controller/procesar_venta.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("¡Compra realizada exitosamente!");
                cart = [];
                localStorage.removeItem('cart');
                actualizarCarrito();
            } else {
                alert("Hubo un error al procesar la compra.");
            }
        })
        .catch(error => {
            console.error('Error en la compra:', error);
            alert("Error en la conexión con el servidor.");
        });
    });

    actualizarCarrito();
});
function filtrarCategoria(categoria) {
    const cards = document.querySelectorAll('#book-list .card');

    cards.forEach(card => {
        const categoriaTexto = card.querySelector('.card-text strong')?.nextSibling?.textContent?.trim();
        if (categoria === 'Todos' || categoriaTexto === categoria) {
            card.parentElement.style.display = 'block';
        } else {
            card.parentElement.style.display = 'none';
        }
    });
}


>>>>>>> 681627f6ed9bf0c515773cd85c45954592b9e126
