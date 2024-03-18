<?php
/**
 * File: 
 * 
 * libreria plotly
 * 
 * @package 
 * @subpackage 
 * @since
 * @author Anderson Chila
 */

function MapsPruebasPlotly($atts, $content = null){
	
	    ob_start();  
?>

<head>
	<!-- Load plotly.js into the DOM -->
	<script src='https://cdn.plot.ly/plotly-2.24.1.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script>
</head>





<body>
	<section class="secundarias impacto">
		<div class="filtros">

			<div class="container">
				<div class="row">
					<div class="col">
						<h2>Datos</h2>
					</div>
				</div>
				<div class="form-row align-items-end">
					<!-- filtro1 -->
					<div class="col-md-6 col-lg-3 px-3">
						<label class="mt-2">Fuente</label>
						<select class="custom-select" id="categoryMapsClass">
						<option value>Seleccione una opción</option>
						</select>
					</div>
					<!-- filtro2 -->
						<div class="col-md-6 col-lg-3 px-3">
						<label class="mt-2">Parametro</label>
						<select class="custom-select" id="filterMapsTwo">
							<option value>Seleccione una opción</option>
							</select>
					</div>
					<!-- filtro3 -->
						<div class="col-md-6 col-lg-3 px-3">
						<label class="mt-2">Instrumento</label>
						<select class="custom-select" id="FilterMapsThree">
							<option value>Seleccione una opción</option>
							</select>
					</div>
					
					
					
					    <!-- Filtered results will be displayed here -->
					  <div id="results">
    
    					</div>
					
					
					
					
					<div class="col-md-6 col-lg-3 px-3">
						<button id="filtroMapsBtn" class="btn btn-enviar " type="submit">FILTRAR</button>
					</div>
				</div>
			</div>
		</div>
		<div class="container position-relative">
			<div class="flecha1"></div>
		</div>
	  
<div class="container">
		<div id='myDiv'></div>
	
	
	<div class="d-flex justify-content-between">
    <div></div>
    <div class="ml-auto"><button class="btn btn-outline my-5 " id="downloadDataBtn">Descargar Datos</button></div>
</div>
	
	

	

		</div>
	
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

		<script>
			
const csvFile = 'https://www.terraegeoambiental.org/wp-content/uploads/2023/11/TERRAE_BD_largo_GEOSTATS_publico.csv';

d3.csv(csvFile, function(rows) {
    function unpack(rows, key) {
        return rows.map(function(row) {
            return row[key];
        });
    }

    // Obtener la lista de nombres únicos
    const uniqueNames = [...new Set(unpack(rows, 'FUENTE'))];
    const uniqueFilterTwo = [...new Set(unpack(rows, 'PARAMETRO_desc'))];
    const uniqueFilterThree = [...new Set(unpack(rows, 'INSTR_desc'))];
  	const modcolor = [...new Set(unpack(rows, 'MODA'))];
	
    // Llenar la lista desplegable con los nombres
    const nameSelector = document.getElementById('categoryMapsClass');
    const filterTwo = document.getElementById('filterMapsTwo');
    const filterThree = document.getElementById('FilterMapsThree');

    // Constructor de opciones para el primer select
    uniqueNames.forEach(name => {
        const option = document.createElement('option');
        option.value = name;
        option.text = name;
        nameSelector.appendChild(option);
    });
	
	

	
	
	
	// Función para actualizar el gráfico según el nombre seleccionado
   function updateMap(selectedValue1, selectedValue2, selectedValue3) {
    const filteredRows = rows.filter(row => (row.FUENTE === selectedValue1 || !selectedValue1) && (row.PARAMETRO_desc === selectedValue2 || !selectedValue2) && (row.INSTR_desc === selectedValue3 || !selectedValue3));

    var modcolor = filteredRows.map(row => row.MODA); // Calcular el color según los datos filtrados

    var data = [
        {
            type: "scattermapbox",
            lat: unpack(filteredRows, 'coord_Lat'),
            lon: unpack(filteredRows, 'coord_Long'),

            hovertemplate: '<b>Fuente: %{customdata[0]}</b><br>' +
                'Numero de muestras: %{customdata[1]}<br>' +
                'Moda: %{customdata[2]}<br>' +
                'Unidad de parámetro: %{customdata[3]}',
            customdata: filteredRows.map(row => [row.COD, row.N, row.MODA, row.PARAMETRO_unidad]),
            marker: {
                color: modcolor, // Utilizar el color calculado
                size: 15,
                opacity: 0.7,
                colorscale: 'Viridis',
                colorbar: {
                    title: "MODA",
                }
            }
        }
    ];

    var layout = {
        dragmode: "zoom",
        mapbox: {
            center: {
                lat: 4.3,
                lon: -73
            },
            zoom: 4,
            style: 'carto-positron'
        },
        margin: { r: 0, t: 0, b: 0, l: 0 },
        hovermode: 'closest',
        font: {
            family: 'Roboto Condensed',
            size: 15
        },
        height: 600
    };

    Plotly.newPlot("myDiv", data, layout);
}

	
    // Función para actualizar el segundo select basado en el primer select
    function updateFilterTwo() {
        const selectedValue1 = nameSelector.value;
        filterTwo.innerHTML = ''; // Limpiar opciones anteriores

        const filteredOptions = uniqueFilterTwo.filter(option =>
            rows.some(row => row.FUENTE === selectedValue1 && row.PARAMETRO_desc === option)
        );

        filteredOptions.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.text = option;
            filterTwo.appendChild(optionElement);
        });

        // Actualizar el tercer select basado en el segundo select
        updateFilterThree();
    }

    // Constructor de opciones para el segundo select
    updateFilterTwo();

    // Función para actualizar el tercer select basado en el segundo select
    function updateFilterThree() {
        const selectedValue1 = nameSelector.value;
        const selectedValue2 = filterTwo.value;
        filterThree.innerHTML = ''; // Limpiar opciones anteriores

        const filteredOptions = uniqueFilterThree.filter(option =>
            rows.some(row => row.FUENTE === selectedValue1 && row.PARAMETRO_desc === selectedValue2 && row.INSTR_desc === option)
        );

        filteredOptions.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.text = option;
            filterThree.appendChild(optionElement);
        });
    }

    // Constructor de opciones para el tercer select
    updateFilterThree();

    // Event listeners para actualizar los selects
    nameSelector.addEventListener('change', updateFilterTwo);
    filterTwo.addEventListener('change', updateFilterThree);

    // Event listener para actualizar el mapa cuando cambian los filtros
    filterThree.addEventListener('change', function() {
        const selectedValue1 = nameSelector.value;
        const selectedValue2 = filterTwo.value;
        const selectedValue3 = filterThree.value;
        updateMap(selectedValue1, selectedValue2, selectedValue3);
		
    });

    // Actualizar el mapa inicialmente
    updateMap();
	
	  const btnfunctionfilter = document.getElementById('filtroMapsBtn');
	btnfunctionfilter.addEventListener('click', function() {
		const selectedValue1 = nameSelector.value;
        const selectedValue2 = filterTwo.value;
        const selectedValue3 = filterThree.value;
		updateMap(selectedValue1, selectedValue2, selectedValue3);
  });
	
	
	
	
	
	
	// Función para descargar los datos filtrados en formato CSV
function downloadFilteredData() {
    const selectedValue1 = document.getElementById('categoryMapsClass').value;
    const selectedValue2 = document.getElementById('filterMapsTwo').value;
    const selectedValue3 = document.getElementById('FilterMapsThree').value;

    const filteredRows = rows.filter(row =>
        (row.FUENTE === selectedValue1 || !selectedValue1) &&
        (row.PARAMETRO_desc === selectedValue2 || !selectedValue2) &&
        (row.INSTR_desc === selectedValue3 || !selectedValue3)
    );

    // Convertir los datos filtrados a formato CSV
    const csvContent = "data:text/csv;charset=utf-8,"
        + Object.keys(filteredRows[0]).join(",") // Encabezados
        + "\n"
        + filteredRows.map(row => Object.values(row).join(",")).join("\n"); // Filas

    // Crear un enlace temporal para descargar el archivo CSV
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "datos_filtrados.csv");
    document.body.appendChild(link); // Añadir el enlace al cuerpo del documento
    link.click(); // Simular un clic en el enlace para iniciar la descarga
}

// Asociar la función de descarga al evento click del botón
const downloadBtn = document.getElementById('downloadDataBtn');
downloadBtn.addEventListener('click', downloadFilteredData);

	
	
	
	
	
	
	
	
	
	
	
});



			
  

</script>
		
	</section>
</body>

 
	<?php
	

}


add_shortcode('mapspruebasplotly', 'MapsPruebasPlotly');


