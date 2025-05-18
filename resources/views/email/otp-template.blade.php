<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>OTP Verification</title>
  </head>
  <body style="margin:0; padding:0; font-family:Arial, sans-serif; background-color:#f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px 0;">
      <tr>
        <td align="center">
          <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
            <tr>
              <td align="center" style="padding:10px 0;">
                <h2 style="color:#333333; margin:0;">Sales Inventory System</h2>
                <p style="color:#888888; font-size:14px;">Secure Login Verification</p>
              </td>
            </tr>
            <tr>
              <td style="padding:20px 0; text-align:center;">
                <p style="font-size:16px; color:#333333; margin:0;">Hello Mr / Mrs <strong>Welcome</strong>,</p>
                <p style="font-size:16px; color:#333333; margin:10px 0 20px;">Use the following OTP to verify your login request:</p>
                <div style="display:inline-block; padding:10px 20px; background-color:#007BFF; color:#ffffff; font-size:24px; font-weight:bold; border-radius:4px; letter-spacing:5px;">
                  {{$otp}}
                </div>
                <p style="font-size:14px; color:#888888; margin-top:20px;">This OTP is valid for the next 10 minutes.</p>
              </td>
            </tr>
            <tr>
              <td align="center" style="padding:20px 0;">
                <p style="font-size:12px; color:#aaaaaa;">If you did not request this OTP, please ignore this message or contact support.</p>
                <p style="font-size:12px; color:#aaaaaa;">&copy; 2025 Sales Inventory System</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
