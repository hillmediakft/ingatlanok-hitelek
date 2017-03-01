<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Árváltozás</title>
    </head>
    <body style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
        <table border="0" cellpadding="0" cellspacing="0" border-collapse="separate" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6; width: 100%;">
            <tr>
                <td>&nbsp;</td>
                <td style=" display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: auto !important; width: 580px;">
                    <div style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table style=" background: #fff; border-radius: 3px; width: 100%;">

                            <!-- START MAIN CONTENT AREA -->
                            <tr>
                                <td style="box-sizing: border-box; padding: 20px;">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <p style="color: #666; font-size: 18px; font-weight: 700">Tisztelt {user_name}!</p>
                                                <p>Az alábbi ingatlan ára megváltozott:</p>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left">
                                                                <table border="0" cellpadding="0" cellspacing="5">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 100px;">Ingatlan azonosító:</td><td>{ingatlan_ref_id}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 100px;">Ingatlan név:</td><td>{ingatlan_nev}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 100px;">Eredeti ár:</td><td>{ar_eredeti} Ft</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 100px;">Új ár:</td><td>{ar_uj} Ft</td>
                                                                        </tr> 
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- END MAIN CONTENT AREA -->
                        </table>

                        <div style="margin-top:20px; text-align: center;">
                            <a href="{url}" target="_blank">Az ingatlan adatlapja.</a>
                        </div>


                        <!-- START FOOTER -->
                        <div style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
                            <hr style="border: 0; border-bottom: 1px solid #fff; Margin: 10px 0;">
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                <tr>
                                    <td style="color: #999999; font-size: 12px; text-align: center">
                                        <p style="color: #999999; font-size: 12px; text-align: center;">Ezt az üzenetet a {from_name} küldte!</p>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                            </table>
                        </div>

                        <!-- END FOOTER -->

                        <!-- END CENTERED WHITE CONTAINER --></div>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>