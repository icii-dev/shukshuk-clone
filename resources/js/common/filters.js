import Vue from 'vue';

Vue.filter('formatCurrency', function (amount) {
    amount = Number(amount);

    if (Number.isNaN(amount)) {
        amount = 0;
    }
    let currency = process.env.MIX_APP_CURRENCY;
    switch (currency){
        case 'IDR':
            return 'Rp ' + String(amount).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        case 'KRW':
            return  String(amount).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' KRW';
    }
});