jQuery(document).ready(function($){

    // Parse the URL
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\[").replace(/[\]]/, "\]");
        var regex = new RegExp("[\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    //Get the URL parameters
    var utm_source = getParameterByName('utm_source');
    var utm_medium = getParameterByName('utm_medium');
    var utm_campaign = getParameterByName('utm_campaign');
    var utm_content = getParameterByName('utm_content');
    var utm_term = getParameterByName('utm_term');

    var referrer = '';
    var refurl = document.referrer;


    if(utm_medium == 'cpc'){
        referrer = 'Paid Search';
    }else if(utm_medium == 'email'){
        referrer = 'Email'
    }else if(refurl.indexOf("google.com") > -1 || refurl.indexOf("bing.com") > -1 || refurl.indexOf("yahoo.com") > -1 ){
        referrer = 'Organic search';
    }else if(refurl.indexOf('facebook.com') > -1){
        referrer = 'Facebook';
    }else if(refurl.indexOf('linkedin.com') > -1){
        referrer = 'LinkedIn';
    }else if(refurl.indexOf('twitter.com') > -1){
        referrer = 'Twitter';
    }else if(refurl && refurl != ""){
        referrer = 'Online referrals';
    }else{
        referrer = 'Direct search';
    }

    //Set them in the local storage
    if(utm_source) Cookies.set('utm_source', utm_source, { expires: 30 })
    if(utm_medium) Cookies.set('utm_medium', utm_medium, { expires: 30 });
    if(utm_campaign) Cookies.set('utm_campaign', utm_campaign, { expires: 30 });
    if(utm_content) Cookies.set('utm_content', utm_content, { expires: 30 });
    if(utm_term) Cookies.set('utm_term', utm_term, { expires: 30 });


    function setutm(param, val){
        if (Cookies.get(param) != undefined) {
            jQuery('.gf_'+param).val('');
            jQuery('.gf_'+param).val(Cookies.get(param));
            console.log(param + " set from cookies");
        }else{
            if(val){
                jQuery('.gf_'+param).val('');
                jQuery('.gf_'+param).val(val);
                console.log(param + " set from parameters");
            }else{
                console.log(param + " not set");
            }
        }
    }

    setutm('utm_source',utm_source);
    setutm('utm_medium',utm_medium);
    setutm('utm_campaign',utm_campaign);
    setutm('utm_content',utm_content);
    setutm('utm_term',utm_term);
    setutm('referrer',referrer);

   

});