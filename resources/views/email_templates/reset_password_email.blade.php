<table>
    <tr>
        <td>
            <p>Reset your password</p>
            <!-- <h2>You are just one step away</h2> -->
            <p>Please click the below link to set password for your account with Simreka</p>
            <table >
                @if(!empty($name))
                <tr>
                    <td>Name:</td>
                    <td>{{$name}}</td>
                </tr>
                @endif
                @if(!empty($email))
                <tr>
                    <td>Email:</td>
                    <td>{{$email}}</td>
                </tr>
            </table>
            @endif
            <table >
                <tbody>

                    <tr>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td><a href="{{ $url }}" target="_blank"><span class="btn btn-secondary">Reset Password</span></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p>If you received this email by mistake, simply delete it.</p>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td class="content-block powered-by">
            Powered by <a href="https://simreka.com" target="_blank">Simreka</a>.
        </td>
    </tr>
</table>