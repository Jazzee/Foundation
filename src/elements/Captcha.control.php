<?php
/**
 * Captcha element form control;
 */
$errorString = ($element->errorString)?"&amp;error={$element->errorString}":'';
?>
<script>
var RecaptchaOptions = {
   theme : '<?php print $element->getTheme() ?>'
};
</script>

<script type="text/javascript" src='<?php print $element->getServer()?>/challenge?k=<?php print $element->getPublicKey() . $errorString?>'></script>
<noscript>
    <iframe src='<?php print $element->getServer() ?>/noscript?k=<?php print $element->getPublicKey() . $errorString ?>' height="300" width="500" frameborder="0"></iframe><br/>
    <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
    <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
</noscript>