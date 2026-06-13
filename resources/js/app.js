import './bootstrap';
import $ from 'jquery';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



window.$ = $;
window.jQuery = $;

$(document).ready(function () {
    $('#category-tags').on('click', 'button', function () {
        $(this).siblings().removeClass('bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300');
        $(this).siblings().addClass('bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white');
        $(this).addClass('bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300');
        $.get('/cashier/showMenuByCategory/' + $(this).attr('id'), function (data) {
            if (data) {
                $('#menu-list').html('');
                $('#menu-list').html(data);
                $('#no-menu').html('');
            }else{


                $('#menu-list').html('');
                $('#no-menu').html('<div class="mx-auto p-5 bg-primary-400"><p class="text-center text-gray-500 dark:text-gray-400">No menu available</p></div>');
            }
        });
    });
    $('#category-tags button').first().click();
});