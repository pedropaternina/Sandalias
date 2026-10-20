// Datos de contacto en un solo lugar: cámbialos aquí y se actualizan en toda la página.

// NÚMERO DE EJEMPLO: reemplázalo por el real (sin "+", con código de país: 57 = Colombia)
export const WHATSAPP_NUMERO = '573000000000'
export const WHATSAPP_MENSAJE = 'Hola, quiero información sobre las sandalias de Torres Sandals'

export const whatsappUrl = (mensaje = WHATSAPP_MENSAJE) =>
  `https://wa.me/${WHATSAPP_NUMERO}?text=${encodeURIComponent(mensaje)}`

export const INSTAGRAMS = [
  { usuario: 'torres.sandals', url: 'https://www.instagram.com/torres.sandals/' },
  { usuario: 'torres.sandalswoman', url: 'https://www.instagram.com/torres.sandalswoman/' },
]