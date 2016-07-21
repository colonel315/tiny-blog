/**
 * Created by Trey on 6/18/2016.
 */

$('button').on('click', function () {
    $(this).siblings('form').toggleClass('hidden');
});