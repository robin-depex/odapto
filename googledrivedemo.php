<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Picker Example</title>

   <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onApiLoad"></script>
<script>
    function onApiLoad(){
        gapi.load('auth',{'callback':onAuthApiLoad}); 
        gapi.load('picker'); 
    }
    function onAuthApiLoad(){
        window.gapi.auth.authorize({
            'client_id':'649854156531-3vem8qu0bs9hhjij3so0gftk0hannfe7.apps.googleusercontent.com',
            'scope':['https://www.googleapis.com/auth/drive']
        },handleAuthResult);
    } 
    var oauthToken;
    function handleAuthResult(authResult){
        if(authResult && !authResult.error){
            oauthToken = authResult.access_token;
            createPicker();
        }
    }
    function createPicker(){    
        var picker = new google.picker.PickerBuilder()
            .addView(new google.picker.DocsUploadView())
            .addView(new google.picker.DocsView())                
            .setOAuthToken(oauthToken)
            .setDeveloperKey('AIzaSyAJyqPpw2WCGMJ5Q9Xs2aP_Frc7cTZVXI4-649854156531')
            .setCallback(pickerCallback)
            .build();
        picker.setVisible(true);
    }

    function pickerCallback(data) {
        var url = 'nothing';
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
          var doc = data[google.picker.Response.DOCUMENTS][0];
          url = doc[google.picker.Document.URL];
        }
        var message = 'You picked: ' + url;
        document.getElementById('result').innerHTML = message;
      }
</script>
  </head>
  <body>
    <div id="result"></div>
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onApiLoad"></script>
  </body>
</html>