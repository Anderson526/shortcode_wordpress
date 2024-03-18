function formato (val){ 
    while (/(\d+)(\d{3})/.test(val.toString())){ 
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2'); 
    } return val; 
}

addEventListener('DOMContentLoaded', () => {
    const contadores = document.querySelectorAll('.count-title')

    const animarContadores = () => {
        for (const contador of contadores) {
            const actualizar_contador = () => {
                let cantidad_maxima = +contador.dataset.to,
                    valor_actual = +contador.innerText,
                    velocidad = +contador.dataset.speed,
                    incremento = +contador.dataset.interval

                if (valor_actual < cantidad_maxima) {
                    contador.innerText = Math.ceil(valor_actual + incremento)
                    setTimeout(actualizar_contador, velocidad)
                }
                else {
                    contador.innerText = formato(cantidad_maxima)   
                }
            }
        actualizar_contador()
        }
    }
    //IntersectionObserver
    const mostrarContadores = elementos => {
        elementos.forEach(elemento => {
            if(elemento.isIntersecting){
                elemento.target.classList.add('aparecercifra')
                elemento.target.classList.remove('ocultarcifra')
                setTimeout(animarContadores, 300)
            } 
        });
    }

    const observer = new IntersectionObserver(mostrarContadores, {
        threshold: 0.75
    })

    const elementosHTML = document.querySelectorAll('.counter')
    elementosHTML.forEach(elementoHTML => {
        observer.observe(elementoHTML)
    })
})