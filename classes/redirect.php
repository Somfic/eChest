<?php
class Redirect
{
    public static function to($path = null, $miliseconds = 0)
    {
        if (isset($path)) : ?>
            <script>
                console.log('Redirect to <?php echo $path ?>');

                window.setTimeout(function() {
                    window.location.replace('<?php echo $path ?>')
                }, <?php echo $miliseconds ?>);
            </script>
<?php endif;
    }
}
