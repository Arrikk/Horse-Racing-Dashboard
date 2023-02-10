let address;
let swapAmount = $("input.form-control-number");
let swapBtn = $("#convert-coin");
const web3 = new Web3(window.web3.currentProvider);

const getEthersAccount = async () => {
  let ethers = await ethereum.request({ method: "eth_requestAccounts" });
  return ethers[0];
};

// Address to and Contract address
let address_to = "0xEFaa15c7FCF4e1E299d1602d9CbAe0E22F01F7eC";
let contractAddress = "0x774f896898C91Cf0afc69AEA135435fD7aec31a6";
// =================================================================

$(swapBtn).on("click", async function () {

    if(swapAmount.val() == "" || swapAmount.val() <= 0) return;
  // Get the transaction amount
  let amount = getTransactionAmount();
  // ================================================================

  // Create new contract for TOKEN..
  const contract = new web3.eth.Contract(window.abi, contractAddress);
  let ctData = contract.methods.transfer(address_to, amount).encodeABI();

  let selectedAddress = await getEthersAccount();
  let sendObject = {
    // customizable by user during MetaMask confirmation.
    to: address_to, // Required except during contract publications.
    from: selectedAddress, // must match user's active address.
    data: ctData,
  };
  console.log(amount);
  setLoader(true)
  await processTransaction(sendObject)
  setLoader()

  //   const txHash = await ethereum.request({
  //     method: "eth_sendTransaction",
  //     params: [sendObject],
  //   });
  //   console.log(txHash);
});

function getTransactionAmount() {
  let amountT = swapAmount.val();
  let amount = +amountT + Math.pow(10, 18);
  amount = web3.utils.toHex(amount);
  return amount;
}

async function processTransaction(data){
    try {
        let sendTransaction = await web3.eth.sendTransaction(data);
        console.log(sendTransaction)
        let amount = swapAmount.val()
        await axios.get('/api/convert/'+amount)
        NioApp.toast("Transaction Successfully", "success")
    } catch (error) {
        NioApp.Toast("Transaction Cancelled..", "error");
    }
}

function setLoader(loading = false) {
    loading
      ? swapBtn.html(`
        <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div> Please wait...
        `).attr('disabled', 'disabled')
      : swapBtn.html(`<em class="icon ni ni-sign-eth"></em> Convert Coins`).attr('disabled', false);
  }
