<style>
    .header{
        border-bottom: 1.5px solid #F4F4F5;
        background-color: #fff;
    }
</style>

<tr>
    <td class="header">
        <a href="{{ config('app.url') }}" class="header-title">
            <img src="https://shukshuk.com/asset-seller/Img/Logo.png">
            {{ $slot }}
        </a>
    </td>
</tr>
