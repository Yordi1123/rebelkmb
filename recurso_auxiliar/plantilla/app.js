const navItems=document.querySelectorAll('.nav-item');const sections=document.querySelectorAll('.section');const breadcrumb=document.getElementById('breadcrumb');const sidebar=document.querySelector('.sidebar');
const names={dashboard:'Dashboard',pedidos:'Pedidos / Ventas',pronosticos:'Pronósticos',mps:'MPS',mrp:'MRP',inventarios:'Inventarios',compras:'Compras',produccion:'Producción',lotes:'Lotes / Trazabilidad',terminados:'Producto terminado',reportes:'Reportes'};
navItems.forEach(btn=>btn.addEventListener('click',()=>{const id=btn.dataset.section;navItems.forEach(x=>x.classList.remove('active'));btn.classList.add('active');sections.forEach(s=>s.classList.toggle('active',s.id===id));breadcrumb.textContent=names[id];sidebar.classList.remove('open');window.scrollTo({top:0,behavior:'smooth'});setTimeout(initCharts,30)}));
document.getElementById('mobileMenu').addEventListener('click',()=>sidebar.classList.toggle('open'));
let charts={};
const chartDefaults={responsive:true,maintainAspectRatio:false,plugins:{legend:{labels:{font:{size:9},usePointStyle:true,boxWidth:7,color:'#7d8596'}}},scales:{x:{grid:{display:false},ticks:{font:{size:8},color:'#9aa1b0'}},y:{grid:{color:'#f0f1f5'},ticks:{font:{size:8},color:'#9aa1b0'}}}};
function makeChart(id,type,data,options={}){const el=document.getElementById(id);if(!el)return;if(charts[id])charts[id].destroy();charts[id]=new Chart(el,{type,data,options:{...chartDefaults,...options}})}
function initCharts(){
makeChart('demandChart','line',{labels:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago'],datasets:[{label:'Demanda real',data:[720,810,760,930,1010,980,1120,1180],borderWidth:2,tension:.35,pointRadius:2},{label:'Pronóstico',data:[700,780,790,880,970,1000,1080,1150],borderWidth:2,tension:.35,borderDash:[5,4],pointRadius:1}]});
makeChart('inventoryChart','doughnut',{labels:['Materia prima','Producto terminado','Empaques','Otros'],datasets:[{data:[46,28,16,10],borderWidth:0}]},{cutout:'70%',plugins:{legend:{position:'bottom'}}});
makeChart('forecastChart','line',{labels:['Sep','Oct','Nov','Dic','Ene','Feb','Mar','Abr'],datasets:[{label:'Histórico / base',data:[1150,1190,1220,1280,1310,1360,1410,1450],borderWidth:2,tension:.3},{label:'Pronóstico',data:[1200,1240,1290,1340,1380,1430,1480,1530],borderWidth:2,tension:.3,borderDash:[5,4]}]});
makeChart('stockChart','line',{labels:['01','05','10','15','20','25','30'],datasets:[{label:'Stock disponible',data:[82,79,75,81,77,73,76],borderWidth:2,tension:.35,fill:true},{label:'Stock mínimo',data:[55,55,55,55,55,55,55],borderWidth:1,borderDash:[4,4],tension:0}]});
makeChart('productionChart','bar',{labels:['Lun','Mar','Mié','Jue','Vie','Sáb'],datasets:[{label:'Planificado',data:[1200,1350,1400,1500,1450,980],borderRadius:4},{label:'Real',data:[1160,1290,1370,1420,1410,920],borderRadius:4}]});
makeChart('finishedChart','doughnut',{labels:['Producto A','Producto B','Producto C'],datasets:[{data:[42,33,25],borderWidth:0}]},{cutout:'68%',plugins:{legend:{position:'bottom'}}});
}
function showToast(msg){const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),2200)}
document.addEventListener('DOMContentLoaded',initCharts);
