<?php 

  use Tokeng\TokengPage;

  # PAGES

  $FrontpageController = function () {
      
    $challange = "some hash";

    $frontpage = new TokengPage(
      "Welcome to Tokeng! - Tokeng",
      "Welcome to Tokeng!",
      <<<HTML
      <div class="set frontpage">
        <h2>Tokeng: Match'n Learn</h2>
        <p>Tokeng is a social utility that matches you with the people to help you learn English.</p>
        <p>You can use Tokeng to :</p>
        <ul class="list">
          <li><p>Create a profile page</p></li>
          <li><p>Randomly match with people with the same level of you</p></li>
          <li><p>Find people to pair with on learning English</p></li>
        </ul>
      </div>
      <div class="set login-box">
        <h2>Login</h2>
        <form action="/login" method="post">
          
          <input type="hidden" id="challange" name="challange" value="'. $challange .'">

          <label for="email">Email :</label>
          <input type="email" name="email" id="email" autocomplete="off">

          <label for="pass">Password :</label>
          <input type="password" name="pass" id="pass">
          
          <button type="submit" name="login-button" id="login-button">Login</button>
        
        </form>
      </div>
      HTML,
      false
    );

    $frontpage->render();
  };

  $ErrorPageController = function () {
    $errorpage = new TokengPage(
      "Oops! - Tokeng",
      "Oops!", 
      <<<HTML
      <div class="set">
        <h1>Oops!</h1>
        <p>Something went wrong.</p>
        <a href="/">Go back to home page</a>
       </div>
      <div class="clearfix"></div>
      HTML, 
      false);
    $errorpage->render();
  };

  $AboutPageController = function () {
    $aboutPage = new TokengPage(
      "About - Tokeng",
      "About Tokeng", 
      <<<HTML
      <div class="set half-column">
        <h2 class="underlined-title">The Project</h2>
        <p>Tokeng is a social utility that matches you with the people to help you learn English. When did you last time wondered who knows how much English? We've got the answer!</p>
        <p>You can see the people who has the same level with you. Or you can randomly match with someone to study together!</p>
      </div>
      <div class="set half-column">
        <h2 class="underlined-title">The People</h2>
        <p>Doruk Eray <span style="font-weight: bold; color: var(--dorkodu-smokegray-dim); float: right;">The Creator, Software Engineer</label></p>
      </div>
      <div class="set half-column">
        <h2 class="underlined-title">The Purpose</h2>
        <p>Nothing. (to be honest...)</p>
        <p>Tokeng started as a school project. Our primary goal is to help you develop your English skills by creating an online directory of people and their English knowledge.</p>
        <p>But you can do a few more things here :</p>
        <ul class="list">
          <li><p>Create a profile page</p></li>
          <li><p>Randomly match with people who is equivalent to you in English skills.</p></li>
          <li><p>Find people to pair with on learning English</p></li>
        </ul>
      </div>
    HTML, 
      false);
    $aboutPage->render();
  };

  $TermsPageController = function () {
    $aboutPage = new TokengPage(
      "Terms - Tokeng",
      "Terms of Use",
      <<<HTML
      <div class="set half-column terms" style="width: 63% !important;">
        <a name="Introduction"></a>
        <h2 class="underlined-title">Introduction</h2>
        <p>Welcome to the Tokeng, a social utility that matches you with the people to help you learn English. The Tokeng service is operated by Dorkodu ("Dorkodu"). By using the Tokeng web site (the "Web site") you signify that you have read, understand and agree to be bound by these Terms of Use (this "Agreement"). We reserve the right, at our sole discretion, to change, modify, add, or delete portions of these Terms of Use at any time without further notice. If we do this, we will post the changes to these Terms of Use on this page. Your continued use of the Web site after any such changes constitutes your acceptance of the new Terms of Use. If you do not agree to abide by these or any future Terms of Use, please do not use or access Web site. It is your responsibility to regularly review these Terms of Use.</p>
        <br>

        <a name="Eligibility"></a>
        <h2 class="underlined-title">Eligibility</h2>
        <p>You must be thirteen years of age or older to register as a member of Tokeng or use the Web site. If you are under the age of 13, you are not allowed to register and become a member of Tokeng or access Tokeng content, features and services on the Web Site. Membership in the Service is void where prohibited. By using the Web site, you represent and warrant that you agree to and to abide by all of the terms and conditions of this Agreement. Tokeng may terminate your membership for any reason, at any time.</p>
        <br>
        
        <a name="Member Conduct"></a>
        <h2 class="underlined-title">Member Conduct</h2>
        <p>You understand that the Web site is available for your personal, non-commercial use only. You agree that no materials of any kind submitted through your account will violate or infringe upon the rights of any third party, including copyright, trademark, privacy or other personal or proprietary rights; or contain libelous, defamatory or otherwise unlawful material. You further agree not to harvest or collect email addresses or other contact information of members from the Web site by electronic or other means for the purposes of sending unsolicited emails or other unsolicited communications. Additionally, you agree not to use automated scripts to collect information from the Web site or for any other purpose. You further agree that you may not use Web site in any unlawful manner or in any other manner that could damage, disable, overburden or impair Web site. In addition, you agree not to use the Web site to:</p>
        <ul class="list">
          <li><p>upload, post, email, transmit or otherwise make available any content that we deem to be harmful, threatening, abusive, harassing, vulgar, obscene, hateful, or racially, ethnically or otherwise objectionable;</p></li>
          <li><p>impersonate any person or entity, or falsely state or otherwise misrepresent yourself or your affiliation with any person or entity;</p></li>
          <li><p>upload, post, email, transmit or otherwise make available any unsolicited or unauthorized advertising, promotional materials, "junk mail," "spam," "chain letters," "pyramid schemes," or any other form of solicitation;</p></li>
          <li><p>upload, post, email, transmit or otherwise make available any material that contains software viruses or any other computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer software or hardware or telecommunications equipment;</p></li>
          <li><p>intimidate or harass another;</p></li>
          <li><p>use or attempt to use another's account, service or system without authorization from Web site, or create a false identity on this website.</p></li>
        </ul>
        <br>
        
        <a name="Proprietary Rights in Content on Tokeng"></a>
        <h2 class="underlined-title">Proprietary Rights in Content on Tokeng</h2>
        <p>All content on Web site, including but not limited to design, text, graphics, other files, and their selection and arrangement (the "Content"), are the proprietary property of Tokeng or its licensors. All rights reserved. The Content may not be modified, copied, distributed, framed, reproduced, republished, downloaded, displayed, posted, transmitted, or sold in any form or by any means, in whole or in part, without Web site's prior written permission. You may download or print a copy of any portion of the Content solely for your personal, non-commercial use, provided that you keep all copyright or other proprietary notices intact. You may not republish Content on any Internet, Intranet or Extranet site or incorporate the information in any other database or compilation. Any other use of the Content is strictly prohibited.</p>
        <p>All trademarks, logos, trade dress and service marks on the Web site are either trademarks or registered trademarks of Tokeng or its licensors and may not be copied, imitated, or used, in whole or in part, without the prior written permission of Tokeng.</p>
        <br>

        <a name="Member Disputes"></a>
        <h2 class="underlined-title">Member Disputes</h2>
        <p>You are solely responsible for your interactions with other Tokeng Members. Tokeng reserves the right, but has no obligation, to monitor disputes between you and other Members.</p>
        <br>

        <a name="Links to Other Websites"></a>
        <h2 class="underlined-title">Links to Other Websites</h2>
        <p>The Web site contains links to other web sites. Tokeng is not responsible for the content, accuracy or opinions express in such web sites, and such web sites are not investigated, monitored or checked for accuracy or completeness by us. Inclusion of any linked web site on Tokeng Web site does not imply approval or endorsement of the linked web site by Tokeng. If you decide to leave Tokeng Web site and access these third-party sites, you do so at your own risk.</p>
        <br>
        
        <a name="Disclaimers"></a>
        <h2 class="underlined-title">Disclaimers</h2>
        <p>Tokeng is not responsible for any incorrect or inaccurate Content posted on the Web site or in connection with the Service, whether caused by users of the Web site, Members or by any of the equipment or programming associated with or utilized in the Service. Tokeng is not responsible for the conduct, whether online or offline, of any user of the Web site or Member of the Service. The Service may be temporarily unavailable from time to time for maintenance or other reasons. Tokeng assumes no responsibility for any error, omission, interruption, deletion, defect, delay in operation or transmission, communications line failure, theft or destruction or unauthorized access to, or alteration of, user or Member communications. Tokeng is not responsible for any problems or technical malfunction of any telephone network or lines, computer online systems, servers or providers, computer equipment, software, failure of email or players on account of technical problems or traffic congestion on the Internet or at any web site or combination thereof, including injury or damage to users and/or Members or to any other person's computer related to or resulting from participating or downloading materials in connection with the Web and/or in connection with the Service. Under no circumstances will Tokeng be responsible for any loss or damage, including personal injury or death, resulting from anyone's use of the Web site or the Service, any Content posted on the Web site or transmitted to Members, or any interactions between users of the Web site, whether online or offline. THE WEB SITE, THE SERVICE AND THE CONTENT ARE PROVIDED "AS-IS" AND TOKENG DISCLAIMS ANY AND ALL WARRANTIES, WHETHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION IMPLIED WARRANTIES OF TITLE, MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE OR NON-INFRINGEMENT. TOKENG CANNOT GUARANTEE AND DOES NOT PROMISE ANY SPECIFIC RESULTS FROM USE OF THE WEB SITE AND/OR THE SERVICE.</p>
        <br>

        <a name="Limitation on Liability"></a>
        <h2 class="underlined-title">Limitation on Liability</h2>
        <p>EXCEPT IN JURISDICTIONS WHERE SUCH PROVISIONS ARE RESTRICTED, IN NO EVENT WILL TOKENG BE LIABLE TO YOU OR ANY THIRD PERSON FOR ANY INDIRECT, CONSEQUENTIAL, EXEMPLARY, INCIDENTAL, SPECIAL OR PUNITIVE DAMAGES, INCLUDING ALSO LOST PROFITS ARISING FROM YOUR USE OF THE WEB SITE OR THE SERVICE, EVEN IF TOKENG HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. NOTWITHSTANDING ANYTHING TO THE CONTRARY CONTAINED HEREIN, TOKENG'S LIABILITY TO YOU FOR ANY CAUSE WHATSOEVER, AND REGARDLESS OF THE FORM OF THE ACTION, WILL AT ALL TIMES BE LIMITED TO THE AMOUNT PAID, IF ANY, BY YOU TO TOKENG FOR THE SERVICE DURING THE TERM OF MEMBERSHIP.</p>
        <br>

        <a name="Indemnity"></a>
        <h2 class="underlined-title">Indemnity</h2>
        <p>You agree to indemnify and hold Tokeng, its subsidiaries, affiliates, officers, agents, and other partners and employees, harmless from any loss, liability, claim, or demand, including reasonable attorney's fees, made by any third party due to or arising out of your use of the Service in violation of this Agreement or your violation of any law or the rights of a third party.</p>
        <br>

        <a name="Other"></a>
        <h2 class="underlined-title">Other</h2>
        <p>These Terms of Use constitute the entire agreement between you and Tokeng regarding the use of the Web site and/or the Service, superseding any prior agreements between you and Tokeng relating to your use of the Web site or the Service. The failure of Tokeng to exercise or enforce any right or provision of these Terms of Use shall not constitute a waiver of such right or provision. If any provision of this Agreement is held invalid, the remainder of this Agreement shall continue in full force and effect.</p>
        <br>
        
      </div>
      <div class="set half-column" style="width: 26% !important; float: right !important;">
        <h2 class="underlined-title">Contents</h2>
        <ul class="list">
          <li><p><a href="#Introduction">Introduction</a></p></li>
          <li><p><a href="#Eligibility">Eligibility</a></p></li>
          <li><p><a href="#Member Conduct">Member Conduct</a></p></li>
          <li><p><a href="#Proprietary Rights in Content on Tokeng">Proprietary Rights in Content on Tokeng</a></p></li>
          <li><p><a href="#Member Disputes">Member Disputes</a></p></li>
          <li><p><a href="#Links to Other Websites">Links to Other Websites</a></p></li>
          <li><p><a href="#Disclaimers">Disclaimers</a></p></li>
          <li><p><a href="#Limitation on Liability">Limitation on Liability</a></p></li>
          <li><p><a href="#Indemnity">Indemnity</a></p></li>
          <li><p><a href="#Other">Other</a></p></li>
        </ul>
      </div>
      <div class="clearfix"></div>
      HTML, 
      false);
    $aboutPage->render();
  };

  $RegisterPageController = function () {
    $page = new TokengPage(
      "Register - Tokeng",
      "Register to Tokeng", 
      <<<HTML
      <div class="set intro">
        <h1>Register</h1>
        <p>Fill the form, and start using Tokeng.</p>
        <form class="register-form" action="/register" method="POST">
          
          <input type="hidden" id="challange" name="challange" value="">

          <label for="r-name">Your Name :</label>
          <p style="margin: .25rem; margin-bottom: 0; font-size: .9rem;">People will be able to find you from your name.</p>
          <input class="input-text" type="text" name="r-realname" id="r-realname" autocomplete="off">

          <label for="r-email">Email :</label>
          <input class="input-text" type="email" name="r-email" id="r-email" autocomplete="off">

          <label for="r-pass">Password :</label>
          <div style="margin-bottom: 1rem;">
            <input class="input-text" type="password" name="r-pass" id="r-pass" autocomplete="off">
            <button type="button" id="togglePassword" class="gray" style="font-size: 1rem">Show Password</button>
          </div>
          
          <label for="r-level">English Level :</label>
          <select name="r-level" id="r-level">
            <option value="beginner">Beginner</option>
            <option value="a1">A1</option>
            <option value="a2">A2</option>
            <option value="b1">B1</option>
            <option value="b2">B2</option>
            <option value="c1">C1</option>
            <option value="c2">C2</option>
            <option value="native">Native</option>
          </select>

          <label for="r-web">Link :</label>
          <p style="margin: .25rem; font-size: .9rem;">e.g. http://mywebsite.com</p>
          <input class="input-text" type="email" name="r-web" id="r-web" autocomplete="off">

          <label for="r-bio">Your Bio :</label>
          <p style="margin: .25rem; margin-bottom: 0; font-size: .9rem;">Tell us more about you.</p>
          <textarea name="r-bio" id="r-bio" autocomplete="off"></textarea>

          <button type="submit" name="register" id="register" style="margin-top: 1rem;" onclick="this.disabled=true; this.form.submit();">Register</button>
          </form>
        </div>
        <script>
          var togglePasswordButton = document.getElementById("togglePassword");
          var passwordInput = document.getElementById("r-pass");
          
          togglePasswordButton.addEventListener("click", function () {

            var type = passwordInput.getAttribute("type");

            if(type == "password") {
              passwordInput.setAttribute("type", "text");
              togglePasswordButton.innerText = "Hide Password";
            } else if (type == "text") {
              passwordInput.setAttribute("type", "password");
              togglePasswordButton.innerText = "Show Password";
            }

          })
      </script>
      HTML, 
      false);
    $page->render();
  };

  $ProfilePageController = function ($id) {
    echo "Given User ID :";
    print_r($id);
  };