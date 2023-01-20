let wallets = {
    crypto: [],
    fiat: []
}

let USRate = 0;

let cryptoWalletHTMLholder = $('#render-crypto-wallet-wallets')
let fiatWalletHTMLholder = $('#render-fiat-wallet-wallets')

async function getCoinrimpWallets() {
    try {
        let req = await axios.get('wallets');
        localStorage.setItem('local_wallets', JSON.stringify(req.data.data))
        return req.data.data
    } catch (error) {
        console.log(error.response.data)
    }

}

async function getUSDTprice(){
    try {
        let req = await axios.get('prices/usdt');
        let data = req.data.data;
        USRate = data.length > 0 ? data[0].attributes.market_price : 0
        return
    } catch (error) {
        console.log(error.response.data)
        return 0;
    }
}

async function init() {
   let myWallets = await getCoinrimpWallets();
   await getUSDTprice()
   if(typeof myWallets == 'object'){
       if(myWallets.length > 0) {
       myWallets.filter(wallet => wallet.wallet_type === 'fiat' ? wallets.fiat = [...wallets.fiat, wallet] : wallets.crypto = [...wallets.crypto, wallet])
        renderWallets(wallets)
        console.log(wallets)
       }else{
           cryptoWalletHTMLholder.html('')
           fiatWalletHTMLholder.append(addMore)
       }
   }else{
    cryptoWalletHTMLholder.html('')
    fiatWalletHTMLholder.append(addMore)
   }
}

function renderWallets(wallets) {
    cryptoWalletHTMLholder.html('')
    wallets.crypto.forEach(cryptoWalletHTML)
    fiatWalletHTMLholder.html('')
    wallets.fiat.forEach(fiatWalletHTML)
    fiatWalletHTMLholder.append(addMore)
}

function cryptoWalletHTML(e, i) {
    cryptoWalletHTMLholder.append(walletHTML(e, i))
}
function fiatWalletHTML(e, i) {
    fiatWalletHTMLholder.append(walletHTML(e, i));
}

function walletHTML(e, i){
    let coinRate = getRate(e.prices);
    let conversion = getConversion(coinRate, e.wallet_balance_raw ?? 0);
    console.log(conversion)
    return `
    <div class="col-sm-6 col-lg-4 col-xl-6 col-xxl-4">
    <div class="card card-bordered ${i==0 ? 'is-dark' : ''}">
        <div class="nk-wgw">
            <div class="nk-wgw-inner">
                <a class="nk-wgw-name" href="javascript:;">
                    <div class="nk-wgw-icon is-default">
                        <em>${e.wallet_symbol.charAt(0)}</em>
                    </div>
                    <h5 class="nk-wgw-title title">${e.wallet_name}</h5>
                </a>
                <div class="nk-wgw-balance">
                    <div class="amount">${window.bz.money(e.wallet_balance_raw ?? 0, e.wallet_decimal)}<span class="currency currency-nio">${e.wallet_id}</span></div>
                    <div class="amount-sm">${typeof conversion == 'boolean' ? "Set rate to reveal" : window.bz.money(conversion)}<span class="currency currency-usd">USD</span></div>
                </div>
            </div>
            <div class="nk-wgw-actions">
                <ul>
                    <li><a href="#"><em class="icon ni ni-arrow-up-right"></em> <span>Send</span></a></li>
                    <li><a href="#"><em class="icon ni ni-arrow-down-left"></em><span>Receive</span></a></li>
                    <li><a href="#"><em class="icon ni ni-arrow-to-right"></em><span>Withdraw</span></a></li>
                </ul>
            </div>
            <div class="nk-wgw-more dropdown">
                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                    <ul class="link-list-plain sm">
                        <li><a href="javascript:;">Details</a></li>
                        <li><a href="javascript:;">Edit</a></li>
                        <li><a href="javascript:;">Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!-- .card -->
</div>
    `
}

function addMore() {
    return `<div class="col-md-6 col-lg-4">
    <div class="card card-bordered dashed h-100">
        <div class="nk-wgw-add">
            <div class="nk-wgw-inner">
                <a href="javascript:;" onclick="addMoreWallets()">
                    <div class="add-icon" id="add-more-wallets">
                        <em class="icon ni ni-plus"></em>
                    </div>
                    <h6 class="title">Add New Wallet</h6>
                </a>
                <span class="sub-text">You can add your more wallet in your account my getting updates from Coinrimp.</span>
            </div>
        </div>
    </div>
</div>`
}

function addMoreWallets(e) {
    let btn = $('#add-more-wallets')
    btn.html(window.bz.loading)
    axios.get('wallets/re-query').then(res => {
        localStorage.removeItem('local_wallets')
        window.bz.toast(res?.data?.message, 'success')
        btn.html(`<em class="icon ni ni-plus"></em>`)
        init()
        return;
    }).catch(err => {
        btn.html(`<em class="icon ni ni-plus"></em>`)
        window.bz.toast(err?.response?.data?.message, 'error')
        return;
    })
}

function getRate(price){
    return (price?.data ? price?.data?.attributes?.market_price : 0);
}

function getConversion(rate, amount){
    return rate == 0 ? false : (amount * rate)/USRate;
}

init()


