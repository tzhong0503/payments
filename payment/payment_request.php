 
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment</title>
        <!DOCTYPE html>
        <html>
        <head> 
        </head>
        <body>
            <h1>Payment Request</h1>
            <form method="post" action="https://stg-mpg.revpay-sandbox.com.my/v1/payment" accept-charset="UTF-8">
            <input type="text" name="Merchant_Key" placeholder="Merchant Key" value="LswE3H5qm"><br>
            <input type="text" name="Revpay_Merchant_ID" placeholder="Merchant ID" value="MER00000003667"><br>
            <input type="text" name="Reference_Number" placeholder="Reference Number" value=""><br>
            <input type="text" name="Amount" placeholder="Amount" value=""><br>
            <input type="text" name="Currency" placeholder="Currency" value="MYR"><br>
            <input type="text" name="Transaction_Description" placeholder="Transaction Description" value=""><br>
            <input type="text" name="Customer_IP" placeholder="Customer IP" value="192.168.1.3"><br>
            <input type="text" name="Return_URL" placeholder="Return URL" value="http://localhost/payment/payment_response.php"><br>
            <input type="text" name="Key_Index" placeholder="Key Index" value="2"><br>
            <input type="text" name="Signature" placeholder="Signature" value=""><br>

            <input type="submit" value="Submit">
        </form>
        <script>
            function generateRandomReferenceNumber() {
                const randomNumber = Math.floor(Math.random() * 100000000); 
                const referenceNumber = "RF" + randomNumber.toString().padStart(8, '0');
                document.querySelector('input[name="Reference_Number"]').value = referenceNumber;
            }

            window.addEventListener('load', generateRandomReferenceNumber);

            function generateSignature() {
                const merchantKey = document.querySelector('input[name="Merchant_Key"]').value;
                const merchantId = document.querySelector('input[name="Revpay_Merchant_ID"]').value;
                const referenceNumber = document.querySelector('input[name="Reference_Number"]').value;
                const amount = document.querySelector('input[name="Amount"]').value;
                const currency = document.querySelector('input[name="Currency"]').value;

                const signatureInput = document.querySelector('input[name="Signature"]');
                const signatureValue = merchantKey + merchantId + referenceNumber + amount + currency;

                async function sha512(str) {
                    const encoder = new TextEncoder();
                    const data = encoder.encode(str);
                    const buffer = await crypto.subtle.digest('SHA-512', data);
                    const signature = Array.from(new Uint8Array(buffer))
                        .map(byte => byte.toString(16).padStart(2, '0'))
                        .join('');
                    return signature;
                }

                sha512(signatureValue).then(hash => {
                    signatureInput.value = hash;
                });
            }

            window.addEventListener('load', generateSignature);

            document.querySelector('input[name="Amount"]').addEventListener('input', generateSignature);
        </script>
        </body>
        </html>
        
        </form>
    </body>
    </html>
   