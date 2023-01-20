async function getCoinrimpPrice(id) {
  try {
    let req = await axios.get(`prices/${id}`);
    $('#set-coin-price').attr('disabled', false)
    return req.data.data;
} catch (error) {
      $('#set-coin-price').attr('disabled', false)
    window.bz.toast("Couldnt Get Coin Price", "error");
    return;
  }
}

let walletListItem = $("#price-wallet-list-ul");
let selectedWallet = null;
let walletsID = ["usdt", "bnb", "eth", "usd", "btc", "ngn"];
let currentPriceOBJ = null;

function loadWallets() {
  if (!window.bz.wallets.length > 0)
    return window.bz.toast("😜 Please Load wallets first");
  console.log(window.bz.wallets);
  walletListItem.html("");
  window.bz.wallets.forEach(walletsHtml);
}

loadWallets();

function walletsHtml(e) {
  walletListItem.append(`
        <li class="buysell-cc-item wallet-list-item" data-id="${e.id}">
            <a class="buysell-cc-opt" data-currency="btc">
                <div class="coin-item coin-btc">
                    <div class="coin-icon">
                        ${
                          walletsID.includes(e.wallet_id)
                            ? `<em class="icon ni ni-sign-${
                                e.wallet_id == "ngn" ? "kobo" : e.wallet_id
                              }-alt"></em>`
                            : `<em>${e.wallet_id.charAt(0)}</em>`
                        }
                    </div>
                    <div class="coin-info">
                        <span class="coin-name">${e.wallet_name} (${
    e.wallet_symbol
  })</span>
                        <span class="coin-text">Last Updated: ${window.bz.dateF(
                          e.updatedAt
                        )}</span>
                    </div>
                </div>
            </a>
        </li>
    `);
}

function setPriceFields(prices) {
  console.log(prices)
  let price = prices.attributes;
  $("#market-price").val(price.market_price);
  $("#swap-price").val(price.swap_price);
  $("#buy-price").val(price.buy_price);
  $("#sell-price").val(price.sell_price);
  currentPriceOBJ = prices;
}

function setCoinPrice(btn) {
    btn.html(window.bz.loading).attr('disabled', 'disabled');
    axios.post('prices', {
        market_price: $("#market-price").val(),
        swap_price: $("#swap-price").val(),
        buy_price: $("#buy-price").val(),
        sell_price: $("#sell-price").val(),
        wallet_id: selectedWallet.wallet_id,
        wallet: selectedWallet.id
    }).then(res => {
        window.bz.toast(res.data?.message, "success");
        btn.text("Continue to set price");
        return;
    }).catch(err => {
        btn.text("Continue to set price").attr('disabled', false);
        window.bz.toast("🥲 OOPS.. unable to set coin price", "error");
        return;
    });
}
function updateCoinPrice(btn, id) {
    btn.html(window.bz.loading).attr('disabled', 'disabled');
    axios.put('prices/'+id, {
        market_price: $("#market-price").val(),
        swap_price: $("#swap-price").val(),
        buy_price: $("#buy-price").val(),
        sell_price: $("#sell-price").val(),
        wallet_id: selectedWallet.wallet_id,
    }).then(res => {
        window.bz.toast(res.data?.message, "success");
        btn.text("Continue to set price").attr('disabled', false);
        return;
    }).catch(err => {
        btn.text("Continue to set price").attr('disabled', false);
        window.bz.toast("🥲 OOPS.. unable to set coin price", "error");
        return;
    });
}

$(".wallet-list-item").on("click", async function () {
  let id = $(this).data("id");
  selectedWallet = window.bz.wallets.find((e) => e.id == id);
  currentPriceOBJ = null

  $("#market-price").val(0);
  $("#swap-price").val(0);
  $("#buy-price").val(0);
  $("#sell-price").val(0);

  $('#set-coin-price').attr('disabled', 'disabled')
  $(".n-name").text(selectedWallet.wallet_name);
  $(".c-icon").html(
    `${
      walletsID.includes(selectedWallet.wallet_id)
        ? `<em class="icon ni ni-sign-${
            selectedWallet.wallet_id == "ngn"
              ? "kobo"
              : selectedWallet.wallet_id
          }-alt"></em>`
        : `<em>${selectedWallet.wallet_id.charAt(0)}</em>`
    }`
  );

  let prices = await getCoinrimpPrice(selectedWallet.wallet_id);
  if (prices) setPriceFields(prices[0]);
  console.log(prices);
});

$("#set-coin-price").on("click", function (e) {
    e.preventDefault();
    if(selectedWallet == null) return
    
    console.log("Current", currentPriceOBJ)
  if (currentPriceOBJ != null && currentPriceOBJ.id) {
    updateCoinPrice($(this), currentPriceOBJ.id);
    return
  }else{
    setCoinPrice($(this));
    return
  }
});
