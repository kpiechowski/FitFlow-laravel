// import Chart from 'chart.umd.js';
var polishMonthsShort = [
    'sty',
    'lut',
    'mar',
    'kwi',
    'maj',
    'cze',
    'lip',
    'sie',
    'wrz',
    'paź',
    'lis',
    'gru'
];

function initActivityTypesChar(charData){
    var maxValue = Math.max(...charData.data) + 2;
    var cont = document.getElementById('activityTypeChart').getContext('2d');
    document.getElementById('activityTypeChart').parentNode.querySelector('.load').classList.add('display--none');
    var myChart = new Chart(cont, {
        type: 'bar',
        data: {
            labels: charData.labels,
            datasets: [{
                // label: 'Ilość na rok '+ new Date().getFullYear(),
                label: '',
                legendHidden: true,
                data: charData.data,
                backgroundColor: [
                    'rgba(245, 158, 211, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(25, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',

                ],
                borderColor: [
                    '#ccc'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    max: maxValue,
                    // beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,

                }
            }
        }
    });

}

function initActivityPerMonthChart(charData){
    console.log(charData.data);

    var numericValues = charData.data.filter(value => typeof value === 'number');
    var maxValue = Math.max(...numericValues);
    maxValue+=3;

    document.querySelector('#perMonthChar-current-title').innerHTML = "Aktualnie: "+ charData.current;

    var cont = document.getElementById('activityPerMonthChart').getContext('2d');
    document.getElementById('activityPerMonthChart').parentNode.querySelector('.load').classList.add('display--none');
    var myChart = new Chart(cont, {
        type: 'line',
        data: {
            labels: polishMonthsShort,
            datasets: [{
                // label: 'Ilość na rok '+ new Date().getFullYear(),
                label: '',
                legendHidden: true,
                data: charData.data,
                borderColor: [
                    '#d4a428'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    max: maxValue,
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,

                }
            }
        }
    });
}




document.addEventListener('DOMContentLoaded', function() {


    var activityTypes = fetch('/userPanel/panel/getUserActivityTypesChart')
    .then(response=>{
        if(response.ok) return response.json();
        else throw new Error('Błąd sieciowy: ' + response.status);
    })
    .then(data=>{
        initActivityTypesChar(data);
    })
    .catch(error=>{
        // dodać na divie infor o błędzie pobierania danych
        console.log(error);
    });


    var activityMonths = fetch('/userPanel/panel/getUserActivityPerMonthChart')
    .then(response=>{
        if(response.ok) return response.json();
        else throw new Error('Błąd sieciowy: ' + response.status);
    })
    .then(data=>{
        initActivityPerMonthChart(data);
    })
    .catch(error=>{
        // dodać na divie infor o błędzie pobierania danych
        console.log(error);
    });




    var ctx = document.getElementById('myChart').getContext('2d');


});
