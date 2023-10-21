const MAX_DATOS = 7;
const INTERVAL_REFRESH = 60000;
let dataJsonActual = "";
let myChart= null
let viewActual='';
let itemsGrafico = "";

document.addEventListener("DOMContentLoaded", async function (event){
  //busca el chipId
  chipid = document.querySelector("#chipid").innerHTML;
  console.log("Web Cargada para el chipid: " + chipid);
  await refreshDatos(MAX_DATOS);
  refreshView('temperatura');
  // si es un chip mio recarga cada 10 seg y con 1 solo dato nuevo
  refreshId = setInterval(refreshDatos, INTERVAL_REFRESH, 7);
})

async function refreshDatos(cantfilas) {
  const response = await fetch("https://mattprofe.com.ar/proyectos/app-estacion/datos.php?chipid=" + chipid + "&cant=" + cantfilas)
  const data = await response.json()
  dataJsonActual = data
  
  setTime(dataJsonActual)
  refreshView(viewActual);
}

function setTime(datos){
  topInfo.innerHTML = "";
  hora = datos[0].fecha;
  ubicacion =  datos[0].ubicacion;
  let tpl_clon = tpl__zonetime.content.cloneNode(true);
  tpl_clon.querySelector('#hora').textContent = hora;
  tpl_clon.querySelector('#ubicacion').textContent = ubicacion;
  topInfo.appendChild(tpl_clon);
}

let refreshView = async (view) => {
  viewActual = view;
    main__table.innerHTML = '';
  switch (viewActual){
    case 'temperatura':
      fillElement(main__table,dataJsonActual[0],tpl__temperatura)
      break;
    case 'viento':
      fillElement(main__table,dataJsonActual[0],tpl__viento)
      break;
    case 'fuego':
      fillElement(main__table,dataJsonActual[0],tpl__fuego)
      break;
    case 'presion':
      fillElement(main__table,dataJsonActual[0],tpl__presion)
      break;
    case 'humedad':
      fillElement(main__table,dataJsonActual[0],tpl__humedad)
      break;
    }
    procesar(dataJsonActual,viewActual)
}

/* RELLENA UN ELEMENTO SEGUN LA DATA Y UN TEMPLATE */
function fillElement(padre,data,tpl){
  let template_clon = tpl.content.cloneNode(true);
    for (let index in data){
      // Rellena el tpl si encuentra el id
      if (template_clon.querySelector('#'+index)) {
        template_clon.querySelector('#'+index).textContent = data[index];
      }
    }
    padre.appendChild(template_clon);
}

function procesar(datos,view){
 // Vectores de...
    let fec = []; // fecha
    let tem = []; // temperatura
    let hum = []; // humedad
    let vie = []; // viento
    let fwi = []; // fuego
    let pre = []; // presion
  let hora = ""

  // Recorremos el Json pero al reves. datos viejos a la izquierda nuevos derecha
  for (let i = datos.length-1; i >= 0; i--) {

    hora = datos[i].fecha.split(" ")[1]

    // Carga de vectores para generar el grÃ¡fico
    fec.push(hora.split(":")[0]+":"+hora.split(":")[1]);
    tem.push(datos[i].temperatura);
    hum.push(datos[i].humedad);
    vie.push(datos[i].viento);
    fwi.push(datos[i].fwi);
    pre.push(datos[i].presion);
  }

  // Elimina los ultimos datos de los vectores si el Ãºltimo fec es igual al anteÃºltimo.
  if(fec[fec.length-1] == fec[fec.length-2]){
    fec.splice(fec.length-1,1);
    hum.splice(fec.length-1,1);
    tem.splice(fec.length-1,1);
    vie.splice(fec.length-1,1);
    fwi.splice(fec.length-1,1);
    pre.splice(fec.length-1,1);
  }else{ // Elimina el primer dato de los vectores
    fec.splice(0,1);
    hum.splice(0,1);
    tem.splice(0,1);
    vie.splice(0,1);
    fwi.splice(0,1);
    pre.splice(0,1);
  }


//Guarda los datos dependiendo de la view
switch(view){
  case 'temperatura':
    itemsGrafico =
      [{
        label: 'Temperatura',
        borderColor: '#ffbf69',
        data: tem,
        tension: .4
      }] 
    break;
    case 'humedad':
    itemsGrafico =
      [{
        label: 'Humedad',
        borderColor: '#00bbf9',
        data: hum,
        tension: .4
      }] 
    break;
    case 'presion':
    itemsGrafico =
      [{
        label: 'Presion',
        borderColor: '#6ee55d',
        data: pre,   
        tension: .4
      }] 
    break;
    case 'viento':
    itemsGrafico =
      [{
        label: 'Viento',
        borderColor: '#9be3e3',
        data: vie,
        tension: .4
      }] 
    break;
  case 'fuego':
    itemsGrafico =
      [{
        label: 'Fuego',
        borderColor: '#ec512b',
        data: fwi,
        tension: .4
      }] 
    break;

}
  // invocamos a la funcion que carga y actualiza los datos en el grÃ¡fico
renderCharts(fec, itemsGrafico);
}

// Carga y actualiza el grafico
function renderCharts(fecha, itemsGrafico){

  // si el objeto grÃ¡fico ya esta instanciado lo destruyo para que se vuelva a crear limpio
  if(myChart!=null){
    myChart.destroy();
  }

  const ctx= document.querySelector("#myChart").getContext("2d")

  myChart= new Chart(ctx, {
  type: "line",
  data:{
    labels: fecha,
    datasets: itemsGrafico
    },
    options: {
      elements: {        
        line: {
          borderWidth: 2,
          fill: false,
        },
        point: {
          radius: 6,
          borderWidth: 4,
          backgroundColor: 'white',
          hoverRadius: 8,
          hoverRadiusWidth: 4,  
        }
      },
      animation: {
        duration: 0
      },
      responsiveAnimationDuration: 0,
      responsive: true,
      maintainAspectRatio: false
    }
  })
}
