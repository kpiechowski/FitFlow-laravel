const polishMonthsShort = [
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

class summaryControler{
    constructor(){
    }

    init(){

        this.summaryCharts = {};

        this.initGenericOptions();




    }

    initGenericOptions(){

        this.genericPopup = document.querySelector('.date-config-popup');

        this.genericStartYear = this.genericPopup.querySelector('#generic-start-date-year');
        this.genericEndYear = this.genericPopup.querySelector('#generic-end-date-year');

        this.genericStartYear.addEventListener('change', ()=>{
            this.genericEndYear.setAttribute('min',  this.genericStartYear.value);
        //     console.log(this.genericEndYear.value, this.genericStartYear.value);
        //     if(parseInt(this.genericEndYear.value) < parseInt(this.genericStartYear)) this.genericStartYear.value = this.genericEndYear.value;
        });

        this.genericEndYear.addEventListener('change', ()=>{
            this.genericStartYear.setAttribute('max',  this.genericEndYear.value);
        //     console.log(this.genericEndYear.value, this.genericStartYear.value);
        //     if(parseInt(this.genericEndYear.value) <= parseInt(this.genericStartYear)) this.genericEndYear.value = this.genericStartYear.value;
        });


        this.genericPopup.querySelector('#generic-apply').addEventListener('click',()=>{

            let start_y = this.genericStartYear.value;
            let start_m = (this.genericPopup.querySelector('#generic-start-date-month').value >9 ) ? this.genericPopup.querySelector('#generic-start-date-month').value: "0"+this.genericPopup.querySelector('#generic-start-date-month').value;

            let end_y = this.genericEndYear.value;
            let end_m = (this.genericPopup.querySelector('#generic-end-date-month').value >9 ) ? this.genericPopup.querySelector('#generic-end-date-month').value: "0"+this.genericPopup.querySelector('#generic-end-date-month').value;

            let start = start_y + "-" + start_m;
            let end = end_y + "-" + end_m;

            this.summaryCharts.generic.destroy();

            this.prepareGenericChart(start, end);
        });
    }


    fetchAndReturnJSON(link){
        let json = fetch(link).then(response=>{
            if(response.ok) return response.json();
            else throw new Error('Błąd sieciowy: ' + response.status);
        }).then(data=>{
            return data;
        }).catch(er=>{

        });

        return json;
    }


    displayChart(chartData, name){
        let canv = chartData.cont.querySelector('canvas');
        canv.width=chartData.cont.clientWidth;
        canv.height=chartData.cont.clientHeight;

        chartData.cont.querySelector('.load').classList.add('display--none');


        this.summaryCharts[name] = new Chart(canv.getContext('2d'), {
            type: chartData.type,
            data:{
                labels: chartData.labels,
                datasets: chartData.datasets,
            },
            options: chartData.options
        });

    }


    async prepareGenericChart(start, end){

        const startDate = start;
        const endDate = end;

        const chart_labels = [];
        const chart_data = [];

        let cont =  document.querySelector('#chart-all-ac-timeline');

        let fetch_link = (cont.hasAttribute('data-acType')) ? '/userPanel/panel/getUserActivityPerMonthChartType/'+cont.getAttribute('data-acType') : '/userPanel/panel/getUserActivityPerMonthChartAll';

        let chart_all = {
            json: await this.fetchAndReturnJSON(fetch_link),
            cont:cont,
            type: 'line',
        };

        let currentDate = startDate;
        while (currentDate <= endDate) {
            chart_labels.push(currentDate);
            chart_data.push( (chart_all.json[currentDate] !== undefined) ? chart_all.json[currentDate] : NaN );
            currentDate = this.addOneMonth(currentDate);
        }


        chart_all.labels = chart_labels;
        chart_all.maxValue = Math.max(...Object.values(chart_all.json)) + 2;

        chart_all.datasets = [{
            label: 'Ilość treningów',
            legendHidden: true,
            data: chart_data,
            borderColor: '#f59e0b',
            backgroundColor:'#f59f0b11',
            borderWidth: 4,
            fill: true,
        }];

        chart_all.options = { // options
            maintainAspectRatio: false,
            responsive: false,
            scales: {
                x: {
                    title:{
                        display: false,
                    },
                    ticks: {
                        precision: 0,
                        color:'#fff',
                        font:{
                            size: (chart_labels > 15) ? 10 : 16,
                            weight:'700'
                        }
                    }
                },
                y: {
                    max: chart_all.maxValue,
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color:'#fff',
                        font:{
                            size: 16,
                            weight:'700'
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                backgroundColor: 'lightgray'
            },
        };

        this.displayChart(chart_all, 'generic');

    }


    addOneMonth(date) {
        const [year, month] = date.split('-').map(Number);
        if (month === 12) {
            return `${year + 1}-01`;
        } else {
            const nextMonth = (month < 9) ? `0${month + 1}` : `${month + 1}`;
            return `${year}-${nextMonth}`;
        }
    }



    initYearSlider(currentYear) {
        let index = document.querySelector('.year-summary-wrapp[data-year="'+currentYear+'"]').getAttribute('data-index');
        const yearSlider = new Siema({
            selector: document.querySelector('.year-summary-slider-wrapper'),
            duration: 200,
            easing: 'ease-out',
            perPage: 1,
            startIndex: index,
            draggable: true,
            multipleDrag: false,
            threshold: 20,
            loop: false,
            rtl: false,
            onInit: () => {this.displayYearInfoCharts(index)},
            onChange: () => {this.displayYearInfoCharts(yearSlider.currentSlide)},
        });

        document.querySelector('#year-slider-prev').addEventListener('click',()=>{
            yearSlider.prev();
        });


        document.querySelector('#year-slider-next').addEventListener('click',()=>{
            yearSlider.next();
        });
    }


    displayYearInfoCharts(index){
        console.log(index);
        let slide = document.querySelector('.year-summary-wrapp[data-index="'+index+'"]');
        let year = slide.getAttribute('data-year');


        if(slide.hasAttribute('data-loaded')){
            return;
        }

        fetch('/userPanel/panel/getUserActivityTypesChart/'+year)
        .then(response=>{
            if(response.ok) return response.json();
            else throw new Error('Błąd sieciowy: ' + response.status);
        })
        .then(charData=>{
            // console.log()
            slide.setAttribute('data-loaded', 'true');
            var maxValue = Math.max(...charData.data) + 2;
            var cont = slide.querySelector('#activityTypeChart').getContext('2d');
            slide.querySelector('#activityTypeChart').parentNode.querySelector('.load').classList.add('display--none');
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
        });

        fetch('/userPanel/panel/getUserActivityPerMonthChart/'+year)
        .then(response=>{
            if(response.ok) return response.json();
            else throw new Error('Błąd sieciowy: ' + response.status);
        })
        .then(charData=>{
            var numericValues = charData.data.filter(value => typeof value === 'number');
            var maxValue = Math.max(...numericValues);
            maxValue+=3;

            slide.querySelector('#perMonthChar-current-title').computedStyleMap.display = "none";

            var cont = slide.querySelector('#activityPerMonthChart').getContext('2d');
            slide.querySelector('#activityPerMonthChart').parentNode.querySelector('.load').classList.add('display--none');
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
                        backgroundColor:'#f59f0b11',
                        borderWidth: 4,
                        fill: true,
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
        });

    }


}





const summaryC = new summaryControler();






document.addEventListener('DOMContentLoaded', ()=>{

    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();


    summaryC.init();
    let start = "2023-01", end = "2023-12";
    summaryC.prepareGenericChart(start, end);


    // const datepicker = new DatePicker("#myDatePicker", {
    //     autohide: true, // Opcjonalne: Automatycznie ukrywaj date picker po wyborze daty
    //     format: "yyyy-mm", // Opcjonalne: Format wybranej daty
    //   });


    // init slider for year statistic
    summaryC.initYearSlider(currentYear);




});










    // (async ()=>{

    //     let chart_all = {
    //         json: await summaryC.fetchAndReturnJSON('/userPanel/panel/getUserActivityPerMonthChart'),
    //         cont: document.querySelector('#chart-all-ac-timeline'),
    //         type: 'line',
    //         labels: polishMonthsShort,
    //     };

    //     // let numericValues = chart_all.json.data.filter(value => typeof value === 'number');
    //     chart_all.maxValue = Math.max(...chart_all.json.data.filter(value => typeof value === 'number')) + 2;


    //     chart_all.datasets = [{
    //         label: '',
    //         legendHidden: true,
    //         data: chart_all.json.data,
    //         borderColor: [
    //             '#d4a428'
    //         ],
    //         borderWidth: 1
    //     }];


    //     chart_all.options = { // options
    //         scales: {
    //             y: {
    //                 max: chart_all.maxValue,
    //                 beginAtZero: true,
    //                 ticks: {
    //                     precision: 0
    //                 }
    //             }
    //         },
    //         plugins: {
    //             legend: {
    //                 display: false,

    //             }
    //         }
    //     };


    //     console.log(chart_all);
    //     summaryC.displayChart(chart_all);

    // })();
