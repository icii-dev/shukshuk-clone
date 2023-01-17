<style>
    .footer{
        background: #413EC1;
    }
    .footer-content{
        margin-top: 8px;
        margin-bottom: 24px;
    }
    .footer-content p {
        text-align: center;
    }
</style>
<tr>
    <td style="background: #413EC1;">
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center" style="text-align: center">
                    <div>
                        <img src="https://shukshuk.com/asset-seller/Img/logo-light.png">
                        <span style="font-family: 'Inter';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 24px;
                                        line-height: 29px;
                                        letter-spacing: -0.019em;
                                        text-transform: lowercase;
                                        color: #FFFFFF;">
                            Shukshuk
                        </span>
                    </div>
                    <div class="footer-content">
                        <p>PT. Shukshuk Indonesia Baru</p>
                        <p>Margorejo Indah XVI / Blok C - 501, Kel. Margorejo, Kec.</p>
                        <p>Wonocolo, Kota Surabaya, Prov. Jawa Timur</p>
                    </div>
                    <p style="color: #F4F4F5; opacity: 0.45; text-align: center">
                        &copy; {{ $slot }}
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>
<script>
    import Footer from "../../../../../laradock/DOCUMENTATION/themes/hugo-material-docs/layouts/partials/footer.html";
    export default {
        components: {Footer}
    }
</script>