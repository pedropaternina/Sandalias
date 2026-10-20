const formato = new Intl.NumberFormat('es-CO', {
  style: 'currency',
  currency: 'COP',
  maximumFractionDigits: 0,
})

// Convierte a número valores como 85000, "85000.00", "85.000", "1.250.000" o "$85.000"
export function aNumero(valor) {
  if (typeof valor === 'number') return valor
  let texto = String(valor ?? '').replace(/[^\d.,-]/g, '')

  if (/^-?\d{1,3}(\.\d{3})+(,\d+)?$/.test(texto)) {
    // El punto es separador de miles: "85.000" o "1.250.000,50"
    texto = texto.replace(/\./g, '').replace(',', '.')
  } else {
    // "85000.00" o "85,000.00": se quitan las comas de miles
    texto = texto.replace(/,/g, '')
  }
  return Number(texto)
}

// formatoCop(85000) -> "$ 85.000"
export function formatoCop(valor) {
  const numero = aNumero(valor)
  return Number.isFinite(numero) ? formato.format(numero) : ''
}

// precioConDescuento(100000, 20) -> 80000
export function precioConDescuento(precio, porcentaje) {
  const base = aNumero(precio)
  const descuento = Number(porcentaje) || 0
  return Math.round(base * (1 - descuento / 100))
}