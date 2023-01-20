</div>
</div>
<!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="/Public/assets/js/bundle.js?ver=3.0.0"></script>
<script src="/Public/assets/js/scripts.js?ver=3.0.0"></script>
<script src="/Public/assets/js/charts/gd-default.js?ver=3.0.0"></script>
<script src="/Public/assets/js/charts/chart-ecommerce.js?ver=3.0.0"></script>
<script src="/Public/assets/js/charts/chart-analytics.js?ver=3.0.0"></script>
<script src="/Public/assets/js/libs/datatable-btns.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script> -->

<script src="/Public/js/axios.min.js"></script>

<script>

const logout = () => {
    $('a[href="#logout"]').on('click',  function() {
        localStorage.removeItem('token')
    })
}

logout()

</script>
<script>
    let token = localStorage.getItem("token") ?
        JSON.parse(localStorage.getItem("token")) :
        "";

        let local_wallets = localStorage.getItem('local_wallets') ? JSON.parse(localStorage.getItem("local_wallets")) : []

        requireLogin(token.metamaskToken, token.loginToken)

    axios.defaults.headers['Authorization'] = `Bearer ${token.loginToken}`
    // axios.defaults.baseURL = 'http://horse.lc'




    window.bz = {
        wallets: local_wallets,
        toast: (message, type="info") => {
            toastr.clear();
            NioApp.Toast(message, type, {
                position: 'top-right'
            });
        },
        loading: `<div class="spinner-border text-white" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`,
        defaults: {
            items: [],
            totalItems: 0,
            page: 1,
            loading: true,
            limit: 10,
            order: "DESC",
        },
        headers: {
            authorization: `Bearer ${token}`,
        },
        money: (money, decimal = 2) => {
            return (+money).toFixed(decimal).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        },
        sign: '$',
        currency: 'USD',
        dateF: (dte) => {
            let options = {
                year: 'numeric',
                month: 'long',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
            }
            let theDay = new Date(dte);
            return theDay.toLocaleDateString('en-US', options).replaceAll('/', '-')
        },
        loader: `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
    }
</script>
</body>

</html>