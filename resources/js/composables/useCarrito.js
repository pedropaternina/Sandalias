import { ref } from 'vue';

function cargarCarritoInicial() {
  return JSON.parse(localStorage.getItem('carrito') || '[]');
}

const carrito = ref(cargarCarritoInicial());
const carritoAbierto = ref(false);

function guardarCarrito() {
  localStorage.setItem('carrito', JSON.stringify(carrito.value));
}

export function agregarAlCarrito(tallaSeleccionada, producto) {
  if (!producto || !tallaSeleccionada) return;

  const itemExistente = carrito.value.find(
    item => item.productoId === producto.id && item.varianteId === tallaSeleccionada.id
  );

  if (itemExistente) {
    itemExistente.cantidad += 1;
  } else {
    carrito.value.push({
      productoId: producto.id,
      varianteId: tallaSeleccionada.id,
      nombre: producto.nombre,
      precio: producto.precio,
      talla: tallaSeleccionada.talla,
      imagen: producto.producto_imagen[0]?.url,
      cantidad: 1,
    });
  }

  guardarCarrito();
}

export function cantidadItemsCarrito() {
  return carrito.value.reduce((total, item) => total + item.cantidad, 0);
}

export function obtenerCarrito() {
  return carrito;
}

export function abrirCarrito() {
  carritoAbierto.value = true;
}

export function cerrarCarrito() {
  carritoAbierto.value = false;
}

export function toggleCarrito() {
  carritoAbierto.value = !carritoAbierto.value;
}

export function estaCarritoAbierto() {
  return carritoAbierto;
}