<!DOCTYPE html>
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            
            <meta name='viewport' content='width=device-width'>
            <title>Privacy Policy</title>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/jquery.idealforms.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <link rel="stylesheet" href="css/ani.css">
            <link rel="stylesheet" href="css/animate.css">
            <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="css/homepage.css">
            <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,400i,500,700" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>
        <style>
            .privacy_page{
                background: #f9f9f9;
                padding: 0px 0 30px 0;
            }
            .privacy_page_inner{
               background: #fff;
    padding: 5px 30px;
    box-shadow: 0 0 1px 0px #ddddddad;
    margin-top: 30px;
            }
        </style>
    <body>
        <div class="privacy_page">
            <div class="container">
                <div class='row'>
                    <div style="padding: 20px 15px;" class="col-sm-12">
               <ul class="list-inline">
                  <li class="pull-left"><a style="color:#FFF" href="index.php"><img style="width:150px" src="images/logo.png"></a></li>
                  <?php
                    if(!empty($_SESSION['auth'])){
                        echo '<li class="pull-right"><h3><a  href="dashboard.php">Go to Dashboard →</a></h3></li> ';
                    }else{
                        echo '<li class="pull-right"><h3><a  href="index.php">Home →</a></h3></li> ';
                    }
                  ?>
                   
               </ul>
            </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                      <div class="privacy_page_inner">
                          <h2> <span style="color:#228d7c;font-weight: bold;">Privacy Policy</span></h2>  
                          <h3> What this policy covers</h3>
                          <p>Your privacy is important to us, and so is being transparent about how we collect, use, 
                          and share information about you. This policy is intended to help you understand:</p>
                          <ul>
                            <li> <a href="#privId1"> What information we collect about you? </a> </li>
                            <li> <a href="#privId2"> How we use information we collect? </a>  </li>
                            <li> <a href="#privId3"> How we share information we collect? </a>  </li>
                            <li> <a href="#privId4"> How we store and secure information we collect? </a>  </li>
                            <li> <a href="#privId5"> How to access and control your information? </a>  </li>
                            <li> <a href="#privId6"> How we transfer information we collect internationally? </a> </li>
                            <li> <a href="#privId7"> Other important privacy information? </a> </li>
                         </ul>
                           <p>
                               This Privacy Policy covers the information we collect about you when you use our Apps or services, or otherwise interact with us.
                           </p>    
                           <p>
                               This policy also explains your choices surrounding how we use information 
                               about you, which include how you can object to certain uses of information about you and how
                               you can access and update certain information about you.
                               <b> If you do not agree with this policy, do not access or use our Services or interact with any other aspect of our business.</b>
                           </p>
                           <p>
                               Where we provide the Services under contract with an organization (for example, your employer) that organization controls the
                               information processed by the Services. For more information, please see Notice to End Users below.
                               This policy does not apply to the extent we process personal information in the role of a processor on behalf of such organizations.
                           </p>
                            <h3 id="privId1"> What information we collect about you?</h3>
                            <p>We collect information about you when you provide it to us, when you use our Services, and when other
                              sources provide it to us, as further described below.
                            </p>
                           <p><strong>Information you provide to us</strong></p>
                            <p> 
                              We collect information about you when you input it into the Services . 
                              If you deny to access any information while using the app, we will not ask further to provide them until it’s necessary in the apps to run.
                            </p>
                            <p><strong> <i> Account and Profile Information:</i> </strong></p>
                            <p> 
                              We collect information about you when you register for an account, create or
                              modify your profile, set preferences, sign-up for or make purchases through the Services. 
                              For example, you provide your contact information and, in some cases, billing information,
                              when you register for the Services. You also have the option of adding a display
                              name, profile photo, job title, and other details to your profile information to be displayed in our Services.
                              We keep track of your preferences when you select settings within the Services.
                            </p>
                            <p><strong> <i> Content you provide through our websites:</i> </strong></p>
                            <p> 
                              The Services also include our websites owned or operated by us. 
                              We collect other content that you submit to these websites, which 
                              include social media or social networking websites operated by us. For example, you provide content to us when you provide 
                              feedback or when you participate in any interactive features,  
                              contests, promotions, sweepstakes, activities or events.
                            </p>
                            <p><strong> <i> Information you provide through our support channels: </i>  </strong></p>
                            <p> 
                              The Services also include our customer support, where you may choose to 
                              submit information regarding a problem you are experiencing with a Service.
                              Whether you designate yourself as a technical contact, open a support ticket, speak to one of our 
                              representatives directly or otherwise engage with our support team, you will be asked to provide contact information, a summary of the problem you are
                              experiencing, and any other documentation, screenshots or information that would be helpful in resolving the issue.
                            </p>
                            <p><strong> <i>  Payment Information: </i> </strong></p>
                            <p> 
                              We collect payment and billing information when you register for certain paid Services.
                              For example, we ask you to designate a billing representative, including name and contact information, upon registration.
                              You might also provide payment information,
                              such as payment card details, which we collect via secure payment processing services.
                            </p>
                            <p><strong> Information we collect automatically when you use the Services </strong></p>
                            <p> 
                              We collect information about you when you use our Services, 
                              including browsing our websites and taking certain actions within the Services.
                            </p>
                            <p><strong> <i>  Your use of the Services: </i> </strong></p>
                            <p> 
                              We keep track of certain information about you when you visit and interact with any of our Services. This information includes the features you use;
                              the links you click on; the type, size and filenames of attachments you upload to the Services; frequently used search terms; your team upload the
                              files using Google drive, dropbox and evernote. We access the user information prior to access the 
                              file from these platform, just to access the platform. We also collect 
                              information about the teams and people you work with and how you work with them, like who you collaborate with and communicate with most frequently.
                              If you use a server or data center version of the Services, the information we collect about your use of the Services is limited to clickstream data 
                              about how you interact with and use features in the Services, in addition to content-related information described in "Content you provide through 
                              our products," above.
                            </p>
                            <p><strong> <i>  Device and Connection Information: </i> </strong></p>
                            <p> 
                              We collect information about your computer, phone, tablet, or other devices you use to access the Services. 
                              This device information includes your connection type and settings when you install, access, update, or use our Services. 
                              How much of this information we collect depends on the type and settings of the device you use to access the Services.
                              Server and data center Service administrators can disable collection of this information via the administrator 
                              settings or prevent this information from being shared with us by blocking transmission at the local network level.
                            </p>
                            <p><strong> Information we receive from other sources </strong></p>
                            <p> 
                              We receive information about you from other Service 
                              users, from third-party services, from our related companies, 
                              social media platforms, public databases, and from our business and channel partners. 
                              We may combine this information with information we collect through other means described above. 
                              This helps us to update and improve our records, identify new customers, 
                              create more personalized advertising and suggest services that may be of interest to you.
                            </p>
                            <p><strong> <i> Other services you link to your account: </i> </strong></p>
                            <p> 
                              We receive information about you when you or your administrator integrate 
                              third-party apps, like Integrations, or link a third-party service with our Services. 
                              For example, if you create an account or log into the Services using your Google credentials, we receive your name and email address
                              as permitted by your Google profile settings in order to authenticate you. You or your administrator may also integrate our Services with 
                              other services you use, such as to allow you to access, store, share and edit certain content from a third-party through our Services.
                              For example, you may authorize our Services to access, display and store files from a third-party document-sharing service within the Services interface. 
                              Or you may authorize our Services to connect with a third-party calendaring service 
                              or to sync a contact list or address book so that your meetings and connections are available
                              to you through the Services, so you can invite others to collaborate with you on our Services or so
                              your organization can limit access to certain users. Your administrator may also authorize our Services to
                              connect with a third party reporting service so your organization can review how the Services are being used. 
                              The information we receive when you link or integrate our Services with a third-party service depends on the settings, 
                              permissions and privacy policy controlled by that third-party service. You should always check the privacy 
                              settings and notices in these third-party services to understand what data may be disclosed to us or shared with our Services.
                            </p>
                           <p><strong> <i>Other Partners: </i> </strong></p>
                            <p> 
                              We receive information about you and your activities on and off the Services from third-party partners, such as 
                              advertising and market research partners who provide us with information 
                              about your interest in and engagement with, our Services and online advertisements.
                            </p>
                            <p><strong> <i>Third Party Providers: </i> </strong></p>
                            <p> 
                              We may receive information about you from third party 
                              providers of business information and publicly available sources (like social media platforms),
                              including physical mail addresses, job titles, email addresses, phone numbers, intent data (or user behaviour data),
                              IP addresses and social media profiles, for the purposes of targeted advertising
                              of products that may interest you, delivering personalized communications, event promotion, and profiling.
                            </p>
                            <h3 id="privId2">How we use information we collect?</h3>
                            <p> 
                              How we use the information we collect depends in part on which Services you use,
                              how you use them, and any preferences you have communicated to us.
                              Below are the specific purposes for which we use the information we collect about you.
                            </p>
                            <p><strong> <i>To provide the Services and personalize your experience: </i> </strong></p>
                            <p> 
                              We use information about you to provide the Services to you, including to process 
                              transactions with you, authenticate you when you log in, provide customer support, and operate, 
                              maintain, and improve the Services. 
                              For example, we use the name and picture you provide in your account to identify you to other Service users. Our Services also include 
                              tailored features that personalize your experience, enhance your productivity, and improve your ability to collaborate effectively with others 
                              by automatically analyzing the activities of your team to provide search results, activity feeds, notifications, connections and recommendations
                              that are most relevant for you and your team.
For example, we may use your stated job title and activity to return search results we think are relevant to your job function.
We also use information about you to connect you with other team members seeking your subject matter expertise. 
We may use your email domain to infer your affiliation with a particular organization or industry to personalize 
the content and experience you receive on our websites. Where you use multiple Services, 
we combine information about you and your activities to provide an integrated experience, 
such as to allow you to find information from one Service while searching from another 
or to present relevant product information as you travel across our websites.
                            </p>
                            <p><strong> <i>For research and development: </i> </strong></p>
                            <p> 
                              We are always looking for ways to make our Services smarter, faster, secure, 
                              integrated, and useful. We use information and collective learnings (including feedback) about 
                              how people use our Services to troubleshoot, to identify trends, usage, activity patterns, and areas for integration and to 
                              improve our Services and to develop new products, features and technologies that benefit our users and the public. For example,
                              to improve the @mention feature, we automatically analyze recent interactions among users and how often they @mention one another
                              to surface the most relevant connections for users. We automatically analyze and aggregate frequently used search terms to improve 
                              the accuracy and relevance of suggested topics that auto-populate when you use the search feature. In some cases, we apply these learnings 
                              across our Services to improve and develop similar features, to better integrate the Services you use, or to provide you with insights based
                              on how others use our Services. We also test and analyze certain new features with some users before rolling the feature out to all users.
                            </p>
                            <p><strong> <i>To communicate with you about the Services: </i> </strong></p>
                            <p> 
                              We use your contact information to send transactional communications via email and within the Services, including confirming your purchases, 
                              reminding you of subscription expirations, responding to your comments, questions and requests, providing customer support, and sending you 
                              technical notices, updates, security alerts, and administrative messages.
                              We send you email notifications when you or others interact with you on the Services, for example, when you are @mentioned on a page or ticket, when a task is 
                              assigned to you, or when you are added to a Trello board. 
                              We also provide tailored communications based on your activity and interactions with us.
                              For example, certain actions you take in the Services may automatically trigger a feature or third-party app suggestion within the Services that would make that task easier.
                              We also send you communications as you on board to a particular Service to help you become more proficient in using that Service. 
                              These communications are part of the Services and in most cases you cannot opt out of them.
                              If an opt out is available, you will find that option within the communication itself or in your account settings.
                            </p>
                            <p><strong> <i>To market, promote and drive engagement with the Services: </i> </strong></p>
                            <p> 
                              We use your contact information and information about how you use the Services to send promotional communications that may be of specific interest to you, 
                              including by email and applications. These communications may be informed by audits of interactions (like counting ad impressions), and are 
                              aimed at driving engagement and maximizing what you get out of the Services, including 
                              information about new features, survey requests, newsletters, and events we think may be of interest to you. We also communicate with you about new Services, 
                              product offers, promotions, and contests.
                              You can control whether you receive these communications as described below under "Opt-out of communications."
                            </p>
                            <p><strong> <i>Customer support: </i> </strong></p>
                            <p> 
                              We use your information to resolve technical issues you encounter, to respond to your requests for assistance, to analyze crash information, and to repair and 
                              improve the Services. 
                              Where you give us express permission to do so, we share information with a third party expert for the purpose of responding to support-related requests.
                            </p>
                            <p><strong> <i>Customer support: </i> </strong></p>
                            <p> 
                              We use your information to resolve technical issues you encounter, to respond to your requests for assistance, to analyze crash information, and to repair and 
                              improve the Services. 
                              Where you give us express permission to do so, we share information with a third party expert for the purpose of responding to support-related requests.
                            </p>
                            <p><strong> <i>For safety and security: </i> </strong></p>
                            <p> 
                              We use information about you and your Service use to verify accounts and activity, to detect, prevent, and respond to potential or
                              actual security incidents and to monitor 
                              and protect against other malicious, deceptive, fraudulent or illegal activity, including violations of Service policies.
                            </p>
                            <p><strong> <i>To protect our legitimate business interests and legal rights: </i> </strong></p>
                            <p> 
                              Where required by law or where we believe it is necessary to protect our legal rights, interests and the interests of others,
                              we use information about you in connection with legal claims, 
                              compliance, regulatory, and audit functions, and disclosures in connection with the acquisition, merger or sale of a business.
                            </p>
                            <p><strong> <i>With your consent:</i> </strong></p>
                            <p> 
                              We use information about you where you have given us consent to do so for a specific purpose not listed above.
                              For example, we may publish testimonials or featured customer stories to promote the Services, with your permission.
                            </p>
                            <h3 id="privId3">How we share information we collect</h3>
                            <p> 
                              We make collaboration tools, and we want them to work well for you.
                              This means sharing information through the Services and with certain third parties. We share information we collect about you in the ways discussed below, 
                              including in connection with possible business transfers. We are not in the business of selling information about you to advertisers or other third parties.
                            </p>
                            <p><strong> Sharing with other Service users </strong></p>
                            <p> 
                             When you use the Services, we share certain information about you with other Service users.
                            </p>
                            <p><strong> <i>For collaboration:</i> </strong></p>
                            <p> 
                              You can create content, which may contain information about you, and grant permission to others to see, share, edit, copy and download that content based on
                              settings you or your administrator (if applicable) select. Some of the collaboration features of the Services display some or all of your profile
                              information to other Service users when you share or interact with specific content. For example, when you comment on a Confluence page or Jira issue,
                              we display your profile picture and name next to your comments so that other users with access to the page or issue understand who made the comment.
                              Similarly, when you publish a Confluence page, your name is displayed as the author of that page, and Service users with permission to view the page 
                              can view your profile information as well. Or your team’s story status in Jira Align can be seen by other users with certain role permissions or 
                              team assignments. Please be aware that some aspects of the Services like Confluence pages, Bitbucket repositories, or Trello boards 
                              can be made publicly available, meaning any content posted in that space, including information about you, can be publicly viewed,indexed by,
                              and returned in search results of search engines.
                              You can confirm whether certain Service properties are publicly visible from within the Services or by contacting the relevant administrator.
                            </p>
                            <p><strong> <i>Managed accounts and administrators:</i> </strong></p>
                            <p> 
                              If you register or access the Services using an email address with a domain that is owned by your employer or organization or 
                              associate that email address with your existing account, and such organization wishes to establish an account or site, certain information about you including your
                              name, profile picture, contact info, content and past use of your account may become accessible to that organization’s administrator and other Service users
                              sharing the same domain. If you are an administrator for a particular site or group of users within the Services, we may share your contact information 
                              with current or past Service users, for the purpose of facilitating Service-related requests. We share information with third parties that help us operate, provide, improve, integrate, customize, support and market our Services.
                            </p>
                            <p><strong> <i>Service Providers: </i> </strong></p>
                            <p> 
                              We work with third-party service providers to provide website and application development, hosting, maintenance, backup, storage, virtual infrastructure, payment 
                              processing, analysis and other services for us, which may require them to access or use information about you.
                              If a service provider needs to access information about you to perform services on our behalf,
                              they do so under close instruction from us, including appropriate security and confidentiality procedures designed to protect your information.
                            </p>
                            <p><strong> <i>Third Party Apps: </i> </strong></p>
                            <p> 
                              You, your administrator or other Service users may choose to add new functionality or change the behavior of the Services by installing third party apps within the Services. 
                              Doing so may give third-party apps access to your account and information about you like your name and email address, and any content you choose to use in connection with those apps.
                              If you are an administrator, or a technical or billing contact listed on an account, we share your details with the third-party app provider upon installation. 
                              Third-party app policies and procedures are not controlled by us, and this privacy policy does not cover how third-party apps use your information. 
                              We encourage you to review the privacy policies of third parties before connecting to or using their applications or services to learn more about their privacy and information handling practices. 
                              If you object to information about you being shared with these third parties, please uninstall the app.
                            </p>
                            <p><strong> <i>Links to Third Party Sites:</i> </strong></p>
                            <p> 
                             The Services may include links that direct you to other websites or services whose privacy practices may differ from ours.
                             If you submit information to any of those third party sites, your information is
                             governed by their privacy policies, not this one. We encourage you to carefully read the privacy policy of any website you visit.
                            </p>
                            <p><strong> <i> Social Media Widgets: </i> </strong></p>
                            <p> 
                             The Services may include links that direct you to other websites or services whose privacy practices may differ from ours. Your use of and any information you submit to 
                             any of those third-party sites is governed by their privacy policies, not this one.
                            </p>
                            <p><strong> <i> Third-Party Widgets: </i> </strong></p>
                            <p> 
                             Some of our Services contain widgets and social media features. These widgets and features collect your IP address, which page you are visiting on the Services, 
                             and may set a cookie to enable the feature to function properly. Widgets and social media features are either hosted by a third party or hosted directly on our Services.
                             Your interactions with these features are governed by the privacy policy of the company providing it.
                            </p>
                            <p><strong> <i> With your consent:  </i> </strong></p>
                            <p> 
                             We share information about you with third parties when you give us consent to do so. For example, we often display personal testimonials of satisfied customers on 
                             our public websites. With your consent, we may post your name alongside the testimonial.
                            </p>
                            <p><strong> <i> Compliance with Enforcement Requests and Applicable Laws; Enforcement of Our Rights:  </i> </strong></p>
                            <p> 
                             In exceptional circumstances, we may share information about you with a third party if we believe that sharing is reasonably necessary to (a) comply with any applicable 
                             law, regulation, legal process or governmental request, including to meet national security requirements, (b) enforce our agreements, policies and terms of service, 
                             (c) protect the security or integrity of our products and services (d) respond to an emergency which we believe in good faith
                             requires us to disclose information to assist in preventing the death or serious bodily injury of any person.
                            </p>
                            <p><strong> Sharing with affiliated companies </strong></p>
                            <p> 
                             We share information we collect with affiliated companies and, in some cases, with prospective affiliates. Affiliated companies are companies owned or operated by us.
                             The protections of this privacy policy apply to the information we share in these circumstances.
                            </p>
                            <p><strong> Business Transfers:  </strong></p>
                            <p> 
                             We may share or transfer information we collect under this privacy policy in connection with any merger, sale of company assets, financing, or acquisition of all or a portion of our 
                             business to another company. You will be notified via email and/or a prominent notice on the Services if a 
                             transaction takes place, as well as any choices you may have regarding your information.
                            </p>
                            <h3 id="privId4">How we store and secure information we collect</h3>
                            <p><strong> Information storage and security  </strong></p>
                            <p> 
                             We use industry standard technical and organizational measures to secure the information we store
                                If you use our server or data center Services, responsibility for securing storage and access to the information you put into the Services rests 
                                with you. We strongly
                                recommend that server or data center users configure SSL to prevent interception of information transmitted over networks and to 
                                restrict access to the databases and other storage points used.
                            </p>
                            <p><strong> How long we keep information  </strong></p>
                            <p> 
                             How long we keep information we collect about you depends on the type of information, as described in further detail below.
                             After such time, we will either delete or anonymize your information or, if this is not possible (for example, because the information has been stored in backup archives), 
                             then we will securely store your information and isolate it from any further use until deletion is possible.
                            </p>
                            <p><strong> <i> Account information:  </i> </strong></p>
                            <p> 
                             We retain your account information for as long as your account is active and a reasonable period thereafter in case you decide to re-activate the Services.
                             We also retain some of your information as necessary to comply with our legal obligations, to resolve disputes, to enforce our agreements, to support business operations,
                             and to continue to develop and improve our Services. Where we retain information for Service improvement and development, we take steps to eliminate information that
                             directly identifies you, and we only use the information 
                             to uncover collective insights about the use of our Services, not to specifically analyze personal characteristics about you.
                            </p>
                            <p><strong> <i> Information you share on the Services:  </i> </strong></p>
                            <p> 
                             If your account is deactivated or disabled, some of your information and the content you have provided will remain in order to allow your team members or other users to make full use of the Services.
                             For example, we continue to display messages you sent to the users that received them and continue to display content you provided, 
                             but when requested details that can identify you will be removed.
                            </p>
                            <p><strong> <i> Managed accounts:  </i> </strong></p>
                            <p> 
                              If the Services are made available to you through an organization (e.g., your employer), we retain your information as long as required by the administrator of your account.
                              For more information, see "Managed accounts and administrators" above.
                            </p>
                            <h3 id="privId5">How to access and control your information?</h3>
                            <p>You have certain choices available to you when it comes to your information. Below is a summary of those choices, how to exercise them and any limitations.</p>
                            <p><strong> <i> Your Choices:  </i> </strong></p>
                            <p> 
                              You have the right to request a copy of your information, to object to our use of your information (including for marketing purposes), to request the deletion or
                              restriction of your information, 
                              or to request your information in a structured, electronic format. Below, we describe the tools and processes for making these requests.
                              You can exercise some of the choices by logging into the Services and using settings available within the Services or your account. Where the Services are 
                              administered for you by 
                              an administrator (see "Notice to End Users" below), you may need to contact your administrator to assist with your requests first. 
                              For all other requests, you may contact us as provided in the Contact Us section below to request assistance.
                            Your request and choices may be limited in certain cases: for example, if fulfilling your request would reveal information about another person, 
                            or if you ask to delete information 
                            which we or your administrator are 
                            permitted by law or have compelling legitimate interests to keep. Where you have asked us to share data with third parties, for example, by installing third-party apps, you 
                            will need to contact 
                            those third-party service providers directly to have your information deleted or otherwise restricted. If you have unresolved concerns, you may have the right to complain to a data 
                            protection authority in the country where you live, where you work or where you feel your rights were infringed.
                            </p>
                            <p><strong> <i> Deactivate your account:  </i> </strong></p>
                            <p> 
                              If you no longer wish to use our Services, you or your administrator may be able to deactivate your Services account. If you can deactivate your own account, that setting is 
                              available to you in your account settings. Otherwise, please contact your administrator. If you are an administrator and are unable to deactivate an account through your administrator settings,
                              please contact the appropriate support team. Please be aware that deactivating your account does not delete your information; your information remains visible to other Service users based on 
                              your past participation within the Services.
                              For more information on how to delete your information, see below.
                            </p>
                            <p><strong> <i> Delete your information:  </i> </strong></p>
                            <p> 
                              Our Services and related documentation give you the ability to delete certain information about you from within the Service. For example,
                              you can remove content that contains information about you using the key word search and editing tools associated with that content, and you can remove certain profile
                              information 
                              within your profile settings. Please note, however, that we may need to retain certain information for record keeping purposes, to 
                              complete transactions or to comply with our legal obligations.
                            </p>
                            <p><strong> <i> Request that we stop using your information:  </i> </strong></p>
                            <p> 
                              In some cases, you may ask us to stop accessing, storing, using and otherwise processing your information where you believe we don't have the appropriate rights to do so.
                              For example, if you believe a Services account was created for you without your permission or you are no longer an active user, you can request that we delete your account as 
                              provided in this policy. 
                              Where you gave us consent to use your information for a limited purpose, you can contact us to withdraw that consent, but this will not affect any processing that has already
                              taken place at the time. You can also opt-out of our use of your information for marketing purposes by contacting us, as provided below. When you make such requests, we may need time to 
                              investigate and facilitate your request. If there is delay or dispute as to whether we have the right to continue using your information, we will restrict any further use of your 
                              information until the request is honored or the dispute is resolved, provided 
                              your administrator does not object (where applicable).
                            </p>
                            <p><strong> <i> Data portability:  </i> </strong></p>
                            <p> 
                              Data portability is the ability to obtain some of your information in a format you 
                              can move from one service provider to another (for instance, when you transfer your mobile phone number to another carrier).
                              Depending on the context, this applies to some of your information, but not to all of your information.
                              Should you request it, we will provide you with an electronic file of your basic account information and the information you create on the spaces under your sole 
                              control, like your personal Bitbucket repository.
                            </p>
                            <h3 id="privId6">How we transfer information we collect internationally</h3>
                            <p><strong> International transfers of information we collect</strong></p>
                            <p> 
                              We collect information globally and may transfer, process and store your information outside of your country of residence, to wherever we or our third-party 
                              service providers operate for the purpose of providing you the Services.
                              Whenever we transfer your information, we take steps to protect it.
                            </p>
                            <p><strong> Privacy Shield Notice </strong></p>
                            <p> 
                             Odapto participate in and comply with the Indian Jurisdiction Privacy Shield Frameworks and the Privacy Shield Principles regarding the collection, use, and retention
                             of information about you that is transferred from the Indian Jurisdiction We ensure that the Privacy Shield Principles apply to all information about you 
                             that is subject to this privacy policy and is received from the Indian and Asian pacific. Under Indian Jurisdiction, we are responsible for the processing of information about you we 
                             receive from the Netherland, the USA, UK and Switzerland and onward transfers to a third party acting as an agent on our behalf. We comply with the Privacy Shield Principles for such 
                             onward transfers and remain liable in accordance with the Privacy Shield Principles if third-party agents that we engage to process such information about you on our behalf
                             do so in a manner inconsistent with the Privacy Shield Principles, unless we prove that we are 
                             not responsible for the event giving rise to the damage.
                            </p>
                            <h3 id="privId7">Other important privacy information</h3>
                            <p><strong> Notice to End Users</strong></p>
                            <p> 
                             Many of our products are intended for use by organizations. Where the Services are made available to you through an organization (e.g. your employer), that organization is 
                             the administrator of the Services and is responsible for the accounts and/or Service sites over which it has control. If this is the case, please direct your data
                             privacy questions to your administrator, as your use of the Services is subject to that organization's policies. We are not responsible 
                             for the privacy or security practices of an administrator's organization, which may be different than this policy.
                            </p>
                             <p> 
                             Administrators are able to:
                            </p>
                            <ul>
                                <li> require you to reset your account password;</li>
                                <li> restrict, suspend or terminate your access to the Services; </li>
                                <li> access information in and about your account; </li>
                                <li> access or retain information stored as part of your account; </li>
                                <li> install or uninstall third-party apps or other integrations </li>
                            </ul>
                             <p> 
                             In some cases, administrators can also:
                            </p>
                            <ul>
                                <li> restrict, suspend or terminate your account access; </li>
                                <li> change the email address associated with your account; </li>
                                <li> change your information, including profile information;  </li>
                                <li> restrict your ability to edit, restrict, modify or delete information </li>
                            </ul>
                            <p> 
                             Even if the Services are not currently administered to you by an organization, if you are a member of a Trello team administered by an organization, or if 
                             you use an email address provided by an organization (such as your work email address) to access the Services, then the owner of the domain associated with your email address 
                             (e.g. your employer) 
                             may assert administrative control over your account and use of the Services at a later date. You will be notified if this happens.
                            </p>
                            <p> 
                             If you do not want an administrator to be able to assert control over your account or use of the Services, you should deactivate your
                             membership with the relevant Trello board, team or enterprise, or use your personal email address to register for or access the Services.
                             If an administrator has not already asserted control over your account or access to the Services, you can update the email address associated with your account through your 
                             account settings in 
                             your profile. Once an administrator asserts control over your account or use of the Services, you will no longer be able to change the email address associated
                             with your account without administrator approval.
                            </p>
                            <p> 
                             Please contact your organization or refer to your administrator’s organizational policies for more information.
                            </p>
                            <p><strong> <i> Sharing your personal information:</i> </strong></p>
                            <p> 
                             We don't sell your personal information. We do share your information with others when you only using our apps or website in order to keep you on loop for
                             the discussion on project 
                             management.
                            </p>
                            <p><strong> <i> Processing your information:  </i> </strong></p>
                            <p> 
                             This policy describes the categories of personal information we may collect, the sources of that information, and our deletion and retention policies. We’ve also included information about
                             how we may process your information, which includes for "business purposes" under the CCPA - such as to protect against illegal activities, and for the development of new products,
                             features, and technologies. If you have questions about the categories of information we may collect about you, please write us 
                             on <a href="help@odapto.com"> help@odapto.com </a> and our representative will assist you on this.
                            </p>
                            <p><strong> Our policy towards children </strong></p>
                            <p> 
                             The Services are not directed to individuals under 16. We do not knowingly collect personal information from children under 16. 
                             If we become aware that a child under 16 has provided us with personal information, we will take steps to delete such information. If you become aware that a child has provided us 
                             with personal information, please contact
                             the appropriate support team 
                            </p>
                            <p><strong>Contact Us</strong></p>
                             <p> 
                             Your information is controlled by Depex technologies Pvt  Ltd and Hoy advies. If you have questions or concerns about how your information is handled, please direct your inquiry 
                             to help@odapto.com, which we have appointed to be 
                             responsible for facilitating such inquiries .
                            </p>
                             <p><strong>Hoy advise </strong></p>
                             <p> 
                             Agnietenstraat 108 <br>
                             2801HZ Gouda, Netherlands <br>
                             E-Mail: Martin_pro@icloud.com <br>
                             San Francisco, CA 94104
                            </p>
                            
                            
                            
                            
                            
                            
                            
                           
                           
                           
                                    
                          <p>
                            odapto built the Odapto app as
                            an Open Source app. This SERVICE is provided by
                            odapto at no cost and is intended for
                            use as is.
                          </p> 
                          <p>
                            This page is used to inform visitors regarding
                            our policies with the collection, use, and
                            disclosure of Personal Information if anyone decided to use
                            our Service.
                          </p> 
                          <p>
                            If you choose to use our Service, then you agree
                            to the collection and use of information in relation to this
                            policy. The Personal Information that we collect is
                            used for providing and improving the Service.
                            We will not use or share your
                            information with anyone except as described in this Privacy
                            Policy.
                          </p>
                          <p>
                            The terms used in this Privacy Policy have the same meanings
                            as in our Terms and Conditions, which is accessible at
                            Odapto unless otherwise defined in this Privacy
                            Policy.
                          </p> 
                          <p><strong>Information Collection and Use</strong></p> <p>
                            For a better experience, while using our Service,
                            we may require you to provide us with certain
                            personally identifiable information, including but not limited to Storage,Contacts. The
                            information that we request will be
                            retained by us and used as described in this privacy policy.
                          </p> 
                          <p>
                            The app does use third party services that may collect
                            information used to identify you.
                          </p>
                          <div><p>
                              Link to privacy policy of third party service providers
                              used by the app
                            </p> 
                            <ul>
                                <li>
                                    <a href="https://www.google.com/policies/privacy/" target="_blank">Google Play Services</a>
                                    </li>
                                    </ul>
                                    </div> 
                                    <p><strong>Log Data</strong></p>
                        <p>
                            We want to inform you that whenever
                            you use our Service, in a case of an error in the
                            app we collect data and information (through third
                            party products) on your phone called Log Data. This Log Data
                            may include information such as your device Internet
                            Protocol (“IP”) address, device name, operating system
                            version, the configuration of the app when utilizing
                            our Service, the time and date of your use of the
                            Service, and other statistics.
                          </p> <p><strong>Cookies</strong></p> <p>
                            Cookies are files with a small amount of data that are
                            commonly used as anonymous unique identifiers. These are
                            sent to your browser from the websites that you visit and
                            are stored on your device's internal memory.
                          </p> <p>
                            This Service does not use these “cookies” explicitly.
                            However, the app may use third party code and libraries that
                            use “cookies” to collect information and improve their
                            services. You have the option to either accept or refuse
                            these cookies and know when a cookie is being sent to your
                            device. If you choose to refuse our cookies, you may not be
                            able to use some portions of this Service.
                          </p> <p><strong>Service Providers</strong></p> <p>
                            We may employ third-party companies
                            and individuals due to the following reasons:
                          </p> <ul><li>To facilitate our Service;</li> <li>To provide the Service on our behalf;</li> <li>To perform Service-related services; or</li> <li>To assist us in analyzing how our Service is used.</li></ul> <p>
                            We want to inform users of this
                            Service that these third parties have access to your
                            Personal Information. The reason is to perform the tasks
                            assigned to them on our behalf. However, they are obligated
                            not to disclose or use the information for any other
                            purpose.
                          </p> <p><strong>Security</strong></p> <p>
                            We value your trust in providing us
                            your Personal Information, thus we are striving to use
                            commercially acceptable means of protecting it. But remember
                            that no method of transmission over the internet, or method
                            of electronic storage is 100% secure and reliable, and
                            we cannot guarantee its absolute security.
                          </p> <p><strong>Links to Other Sites</strong></p> <p>
                            This Service may contain links to other sites. If you click
                            on a third-party link, you will be directed to that site.
                            Note that these external sites are not operated by
                            us. Therefore, we strongly advise you to
                            review the Privacy Policy of these websites.
                            We have no control over and assume no
                            responsibility for the content, privacy policies, or
                            practices of any third-party sites or services.
                          </p> <p><strong>Children’s Privacy</strong></p> <p>
                            These Services do not address anyone under the age of 13.
                            We do not knowingly collect personally
                            identifiable information from children under 13. In the case
                            we discover that a child under 13 has provided
                            us with personal information,
                            we immediately delete this from our servers. If you
                            are a parent or guardian and you are aware that your child
                            has provided us with personal information, please contact
                            us so that we will be able to do
                            necessary actions.
                          </p> <p><strong>Changes to This Privacy Policy</strong></p> <p>
                            We may update our Privacy Policy from
                            time to time. Thus, you are advised to review this page
                            periodically for any changes. We will
                            notify you of any changes by posting the new Privacy Policy
                            on this page. These changes are effective immediately after
                            they are posted on this page.
                          </p><p><strong>Contact Us</strong></p> <p>
                    If you have any questions or suggestions about
                    our Privacy Policy, do not hesitate to contact
                    us at <a href="mailto:odapto@gmail.com">odapto@gmail.com</a>
                  </p>
                  <p>
                    This privacy policy page was created by
                    <a href="https://www.odapto.com/" target="_blank">www.odapto.com</a>
                    </div>
             </div>
             </div>
             </div>
        </div>
    </body>
    </html>
      