import Chart from 'chart.js/auto';

const chartElement = document.getElementById('cashFlowChart');

if (chartElement) {

    new Chart(chartElement, {
        type: 'line',
        data: {
            labels: [
                'Jan','Feb','Mar','Apr','Mei','Jun',
                'Jul','Agu','Sep','Okt','Nov','Des'
            ],
            datasets: [
                {
                    label: 'Income',
                    data: window.monthlyIncome,
                    borderWidth: 2
                },
                {
                    label: 'Expense',
                    data: window.monthlyExpense,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true
        }
    });
}