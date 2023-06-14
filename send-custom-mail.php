<?php
    require(__DIR__ . '/auth-library/resources.php');



    send_custom_mail("folushoayomide11@gmail.com", "Sample Mail", '<!DOCTYPE html>
    <html>
      <head>
        <link rel="stylesheet" href="../assets/fonts/fonts.css" />
      </head>
      <body style="font-family: "Inter", sans-serif !important">
    
        <header style="margin: 50px 0; text-align: center;">
          <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
        </header>
        <main>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style="margin-bottom: 10px; line-height: 1.5;">Dear Damilola,</p>
    
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
              Thank You for choosing <b>HalfCarry</b> as your preferred choice for
              shopping quality products. Your savings request <b>1234567890</b> has been
              processed.
            </p>
          </section>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>
    
            <div style="border: 2px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="https://halfcarry.com.ng/assets/images/4-runner.jpg" style=" height: 100%;
                width: 80px;" />
              </div>
              <div style="display: table; border-collapse: collapse; width: 100%;">
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> ITEM </span>
                  <span style="display: table-cell;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" > 4-Runner OG placard </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 1 </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> # 3,400 </span>
                </p>
              </div>
            </div>
    
            <div style="border: 2px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="https://halfcarry.com.ng/assets/images/4-runner.jpg" style=" height: 100%;
                width: 80px;" />
              </div>
              <div style="display: table; border-collapse: collapse; width: 100%;">
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> ITEM </span>
                  <span style="display: table-cell;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" > 4-Runner OG placard </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 1 </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> # 3,400 </span>
                </p>
              </div>
            </div>
          </section>
          <section style="margin: 50px 10px;">
            <div style="display: table; border-collapse: collapse; width: 100%; border: 2px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Savings Type </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Half Savings </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Duration </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 13 weeks (NGN 12,276.55/week) </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;">  Type of payment </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Weekly </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Amount to save </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN 159,596.40 </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Shodiya Folorunsho </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Email </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> folushoayomide@gmail.com </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Phone </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 07087857141</span>
              </div>
            </div>
          </section>
        </main>
      </body>
    </html>
    ');

    send_custom_mail("sodje.o@gmail.com", "Sample Mail", '<!DOCTYPE html>
    <html>
      <head>
        <link rel="stylesheet" href="../assets/fonts/fonts.css" />
      </head>
      <body style="font-family: "Inter", sans-serif !important">
    
        <header style="margin: 50px 0; text-align: center;">
          <img src="https://halfcarry.com.ng/assets/images/halfcarry-logo.jpeg" style="width: 150px; height: 80px;"/>
        </header>
        <main>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style="margin-bottom: 10px; line-height: 1.5;">Dear Damilola,</p>
    
            <p style="margin-bottom: 10px; line-height: 1.5; text-align: justify;">
              Thank You for choosing <b>HalfCarry</b> as your preferred choice for
              shopping quality products. Your savings request <b>1234567890</b> has been
              processed.
            </p>
          </section>
          <section style="margin: 50px 10px; font-size: 14px;">
            <p style=" font-size: 16px; margin-bottom: 10px;"><strong>You ordered for</strong></p>
    
            <div style="border: 2px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="https://halfcarry.com.ng/assets/images/4-runner.jpg" style=" height: 100%;
                width: 80px;" />
              </div>
              <div style="display: table; border-collapse: collapse; width: 100%;">
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> ITEM </span>
                  <span style="display: table-cell;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" > 4-Runner OG placard </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 1 </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> # 3,400 </span>
                </p>
              </div>
            </div>
    
            <div style="border: 2px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="height: 80px;
              text-align: center;
              border-bottom: 1px solid #ff5c00;" >
                <img src="https://halfcarry.com.ng/assets/images/4-runner.jpg" style=" height: 100%;
                width: 80px;" />
              </div>
              <div style="display: table; border-collapse: collapse; width: 100%;">
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> ITEM </span>
                  <span style="display: table-cell;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right; width: 100%;" > 4-Runner OG placard </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Quantity </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 1 </span>
                </p>
                <p style="display: table-row; border-bottom: 2px solid #ff5c00;">
                  <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Price </span>
                  <span style="display: table-cell;  padding: 10px;"></span>
                  <span style="display: table-cell;  padding: 10px; font-size: 15px; text-align: right;"> # 3,400 </span>
                </p>
              </div>
            </div>
          </section>
          <section style="margin: 50px 10px;">
            <div style="display: table; border-collapse: collapse; width: 100%; border: 2px solid #ff5c00;
            border-bottom: 5px solid #ff5c00; margin-bottom: 40px;">
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Savings Type </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Half Savings </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Duration </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 13 weeks (NGN 12,276.55/week) </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;">  Type of payment </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Weekly </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Amount to save </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> NGN 159,596.40 </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> Shodiya Folorunsho </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Email </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> folushoayomide@gmail.com </span>
              </div>
              <div style="display: table-row; border-bottom: 2px solid #ff5c00;">
                <span style="display:table-cell;  padding: 10px; font-size: 15px; font-weight: 700;"> Agent Phone </span>
                <span style="display: table-cell;"></span>
                <span style="display:table-cell;  padding: 10px; font-size: 15px; text-align: right;"> 07087857141</span>
              </div>
            </div>
          </section>
        </main>
      </body>
    </html>
    ');
?>