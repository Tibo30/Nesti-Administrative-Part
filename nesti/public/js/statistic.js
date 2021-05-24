// ---------------------------- Orders -----------------------------//
if (typeof totalPurchasedPerDay != "undefined" && typeof totalSoldPerDay != "undefined") {
    const el = document.getElementById('toastOrders');
    const data = {

        categories: [
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9'
        ],

        series: [{
            name: 'Cost',
            data: totalPurchasedPerDay,
        }, {
            name: 'Sells',
            data: totalSoldPerDay,
        }],
    };

    const options = {
        chart: {
            title: '',
            width: 600,
            height: 300
        },
        legend: {
            visible: (screenwidth > 600 ? true : false)
        },
        xAxis: {
            pointOnColumn: false,
            title: {
                text: ''
            }
        },
        yAxis: {
            title: ''
        },
    };

    const chartLog = toastui.Chart.lineChart({
        el,
        data,
        options
    });
}

// ---------------------------- Website Consultation -----------------------------//
if (typeof connectionPerHour != "undefined") {
    const el1 = document.getElementById('toastPieConnection');
    const dataConnectionLogPerHour = {
        categories: ['Connection'],
        series: connectionPerHour
    }
    const optionsConnectionLog = {
        chart: {
            title: '',
            width: 500,
            height: 400
        },
        legend: {
            visible: false
        },
        series: {
            dataLabels: {
                visible: true,
                anchor: 'outer',
                formatter: (value) => value,
                pieSeriesName: {
                    visible: true,
                },
            },
            radiusRange: {
                inner: '60%',
                outer: '100%',
            }
        }

    };
    const chartConection = toastui.Chart.pieChart({
        el: el1,
        data: dataConnectionLogPerHour,
        options: optionsConnectionLog
    });
}
// ---------------------------- Articles -----------------------------//
if (typeof articleBought != "undefined" && typeof articleSold != "undefined" && typeof articles != "undefined") {
    const el2 = document.getElementById('toastArticles');
    var clésDenses = Object.keys(articles);

    const dataArticle = {
        categories: clésDenses,
        series: [{
            name: 'cost amount',
            data: articleBought,
        },
        {
            name: 'sold amount',
            data: articleSold,
        }
        ],
    };
    const optionsArticle = {
        chart: {
            title: "",
            width: 600,
            height: 300
        },
        legend: {
            visible: (screenwidth > 600 ? true : false)
        },
        xAxis: {
            visible: false
        },

    };

    const chartArticle = toastui.Chart.columnChart({
        el: el2,
        data: dataArticle,
        options: optionsArticle
    });
}