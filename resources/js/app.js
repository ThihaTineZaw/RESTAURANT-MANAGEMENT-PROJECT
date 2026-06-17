import "./bootstrap";
import $ from "jquery";
import Alpine from "alpinejs";
import axios from "axios";

window.Alpine = Alpine;

Alpine.start();

window.$ = $;
window.jQuery = $;

$(document).ready(function () {
    $("#category-tags").on("click", "button", function () {
        $(this)
            .siblings()
            .removeClass(
                "bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300",
            );
        $(this)
            .siblings()
            .addClass(
                "bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white",
            );
        $(this).addClass(
            "bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300",
        );
        $.get(
            "/cashier/showMenuByCategory/" + $(this).attr("id"),
            function (data) {
                if (data) {
                    $("#menu-list").html("");
                    $("#menu-list").html(data);
                    $("#no-menu").html("");
                } else {
                    $("#menu-list").html("");
                    $("#no-menu").html(
                        '<div class="mx-auto p-5 bg-primary-400"><p class="text-center text-gray-500 dark:text-gray-400">No menu available</p></div>',
                    );
                }
            },
        );
    });
    $("#category-tags button").first().click();

    $(document).on("click", ".menu-item", function (e) {
        e.preventDefault();
        const categoryId = $(this).attr("category_id");
        const menuId = $(this).attr("menu_id");
        const qty = 1;

        const img = $(this).find("img").attr("menu_img");

        const name = $(this).find("h3").attr("menu_name");
        let price = parseInt(
            ($(this).find("span").attr("menu_price") || "").replace(/,/g, ""),
        );
        const description = $(this).find("p").attr("menu_description");

        let html = `
            <tr name="${name}" menu_id="${menuId}" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">

        <!-- Image -->
        <td class="px-1 py-1 flex items-center justify-center">
            <img
                src="/storage/menus/${img}"
                alt="${name}"
                class="w-8 h-8 rounded-md object-cover ">
        </td>

        <!-- Menu Name -->
        <td class="px-2 py-1">
            <p class="text-xs font-medium text-gray-900 dark:text-white">
                ${name}
            </p>
        </td>

        <!-- Quantity -->
        <td class="px-1 py-1">
            <div class="flex items-center" >

                <button
                    class="qty-decrease w-5 h-5 rounded-l bg-red-500 hover:bg-red-600 text-white text-xs font-bold">
                    -
                </button>

                <span
                    class="qty-value w-8 h-5 flex items-center justify-center border-y border-gray-300  dark:border-gray-600 bg-white dark:text-white dark:bg-gray-800 text-xs font-medium">
                    ${qty}
                </span>

                <button
                    class="qty-increase w-5 h-5 rounded-r bg-green-500 hover:bg-green-600 text-white text-xs font-bold">
                    +
                </button>

            </div>
        </td>

        <!-- Price -->
        <td class="px-2 py-1">
            <span class="text-xs font-medium text-green-600 dark:text-green-400 price-value" original-price="${price}">
                ${price} Ks
            </span>
        </td>

        <!-- Delete -->
        <td class="px-1 py-1 text-center">
            <button
                class="delete-order-menu w-5 h-5 rounded bg-red-100 hover:bg-red-500 text-red-500 hover:text-white text-xs">
                ✕
            </button>
        </td>

    </tr>

    `;
        if ($("#order-list").find(`tr[name="${name}"]`).length == 0) {
            $("#order-list").append(html);
        } else {
            $("#item-already-added").removeClass("hidden");
            $("#item-already-added button").on("click", function () {
                $("#item-already-added").addClass("hidden");
            });
        }

        html = "";
    });

    $(document).on("click", ".delete-order-menu", function (e) {
        e.preventDefault();
        $(this).closest("tr").remove();
    });

    $(document).on("click", ".qty-increase", function (e) {
        e.preventDefault();
        const qty = $(this).closest("td").find(".qty-value").text();
        const newQty = qty * 1 + 1;
        const OriginalPrice = $(this)
            .closest("tr")
            .find(".price-value")
            .attr("original-price");
        const newPrice = OriginalPrice * newQty;
        $(this)
            .closest("tr")
            .find(".price-value")
            .text(newPrice + " Ks");
        $(this).siblings(".qty-value").text(newQty);
    });

    $(document).on("click", ".qty-decrease", function (e) {
        e.preventDefault();
        const qty = $(this).closest("td").find(".qty-value").text();
        const newQty = qty * 1 - 1;
        if (newQty > 0) {
            const OriginalPrice = $(this)
                .closest("tr")
                .find(".price-value")
                .attr("original-price");
            const newPrice = OriginalPrice * newQty;
            $(this)
                .closest("tr")
                .find(".price-value")
                .text(newPrice + " Ks");
            $(this).siblings(".qty-value").text(newQty);
        }
    });

    // Tables Panel Toggle
    $("#open-tables-btn").on("click", function () {
        $("#tables-panel").removeClass("-translate-x-full");
        $("#tables-overlay").removeClass("hidden");
    });

    $("#close-tables-btn, #tables-overlay").on("click", function () {
        $("#tables-panel").addClass("-translate-x-full");
        $("#tables-overlay").addClass("hidden");
    });

    // Select Table
    $(document).on("click", ".table-btn", function () {
        const tableNumber = $(this).data("table-number");
        const tableId = $(this).data("table-id");

        $("#selected-table").text("Table: " + tableNumber);
        $("#selected-table").data("table-id", tableId);

        // Close panel
        $("#tables-panel").addClass("-translate-x-full");
        $("#tables-overlay").addClass("hidden");

        // Highlight selected table
        $(".table-btn").removeClass("ring-2 ring-primary-500");
        $(this).addClass("ring-2 ring-primary-500");
    });

    // Calculate Total Price
    function updateTotal() {
        let total = 0;
        $("#order-list tr").each(function () {
            const priceText = $(this).find(".price-value").text();
            const price = parseInt(priceText.replace(/[^0-9]/g, ""));
            if (!isNaN(price)) {
                total += price;
            }
        });
        $("#total_price").text(total.toLocaleString() + " Ks");
    }

    // Update total when order changes
    $(document).on(
        "click",
        ".menu-item, .qty-increase, .qty-decrease, .delete-order-menu",
        function () {
            setTimeout(updateTotal, 100);
        },
    );

    $("#order-confirm-btn").on("click", function (e) {
        e.preventDefault();
        const tableId = $("#selected-table").data("table-id");
        if (!tableId) {
            alert("Please select a table");
            return;
        } else {
            let orderDetail = {
                order: {
                    total_price: 0,
                    status: "UNPAID",
                    table_number: "",
                },
                orderDetails: [],
            };

            const totalPrice = $("#total_price").text().replace(" Ks", "");
            orderDetail.order.total_price = totalPrice;
            orderDetail.order.status = "UNPAID";
            orderDetail.order.table_number = tableId;

            $("#order-list tr").each(function () {
                const menuId = ($(this).attr("menu_id") || "").trim();
                const qty = ($(this).find(".qty-value").text() || "").trim();
                orderDetail.orderDetails.push({
                    menu_id: menuId,
                    qty: qty,
                });
            });

            if (orderDetail.orderDetails.length == 0) {
                alert("Please add items to the order");
                return;
            }

            axios
                .post("/cashier/order", orderDetail, {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content",
                        ),
                    },
                })
                .then(function (response) {
                    if (response.data == "Order placed successfully") {
                        alert("Order placed successfully");

                        // window.location.reload();
                        // Clear order list
                        $("#order-list").html("");
                        $("#order_id").attr("value", "");
                        updateTotal();
                        $.get(
                            "/cashier/orderCheck/" + tableId,
                            function (data) {
                                $("#order-list").html(data.html);
                                $("#order_id").attr("value", data.order_id);
                                $(".table-btn").removeClass(
                                    "bg-green-50 dark:bg-green-900/20 border-green-500 text-green-700 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30",
                                );

                                $(
                                    `.table-btn[data-table-id="${tableId}"]`,
                                ).addClass(
                                    "bg-yellow-50 dark:bg-yellow-900/20 border-yellow-500 text-yellow-700 dark:text-yellow-400 hover:bg-yellow-100 dark:hover:bg-yellow-900/30",
                                );
                                $("#order-confirm-btn").hide();
                                $("#order-again-btn").removeClass("hidden");
                                $("#order-payment-btn").removeClass("hidden");

                                $(`.table-btn[data-table-id="${tableId}"]`)
                                    .find(".table-status")
                                    .text("unavailable");
                                $(
                                    `.table-btn[data-table-id="${tableId}"]`,
                                ).data("table-status", "unavailable");
                                updateTotal();
                            },
                        );
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    console.log(error.response.data);
                    alert(error.response.data.message);
                });
        }
    });

    $(".table-btn").on("click", function () {

        let tableNumber = $(this).data("table-id");

        const tableStatus = $(this).data("table-status");
        if (tableStatus == "unavailable") {
            $.get("/cashier/orderCheck/" + tableNumber, function (data) {

                $("#order-confirm-btn").hide();
                $("#order-again-btn").removeClass("hidden");
                $("#order-payment-btn").removeClass("hidden");
                $("#order-list").html("");
                $("#order-list").html(data.html);
                $("#order_id").attr("value", data.order_id);

                updateTotal();
            });
        } else {
            $("#order-list").html("");
            $("#order-confirm-btn").show();
            $("#order-again-btn").addClass("hidden");
            $("#order-payment-btn").addClass("hidden");
            $("#order_id").attr("value", "");
            updateTotal();
        }
    });

    let orderAgain = null;
    $("#order-again-btn")
        .off("click")
        .on("click", function (e) {
            e.preventDefault();
            orderAgain = {
                order: {
                    total_price: 0,
                    status: "UNPAID",
                    table_number: "",
                },
                orderDetails: [],
            };
            const tableId = $("#selected-table").data("table-id");
            const totalPrice = $("#total_price").text().replace(" Ks", "");

            orderAgain.order.total_price = totalPrice;
            orderAgain.order.status = "UNPAID";
            orderAgain.order.table_number = tableId;
            $("#order-list tr").each(function () {
                const menuId = ($(this).attr("menu_id") || "").trim();
                const qty = ($(this).find(".qty-value").text() || "").trim();

                orderAgain.orderDetails.push({
                    menu_id: menuId,
                    qty: qty,
                });
            });

            let orderId = $("#order_id").attr("value") || "";
            orderId = orderId.trim();

            $("#order-again-confirm").removeClass("hidden");

            $("#order-again-cancel-btn")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();
                    $("#order-again-confirm").addClass("hidden");
                });

            $("#order-again-confirm-btn")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();
                    let orderId = $("#order_id").attr("value") || "";
                    orderId = orderId.trim();
                    

                    axios
                        .post("/cashier/orderAgain/" + orderId, orderAgain, {
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]',
                                ).attr("content"),
                            },
                        })
                        .then(function (response) {
                            if (
                                response.data.message ==
                                "Order again placed successfully"
                            ) {
                                alert("Order again placed successfully");
                                $("#order-again-confirm").addClass("hidden");
                                $.get(
                                    "/cashier/orderCheck/" +
                                        response.data.table_number,
                                    function (data) {
                                        $("#order-list").html("");
                                        $("#order-list").html(data.html);
                                        $("#order_id").attr(
                                            "value",
                                            data.order_id,
                                        );
                                        updateTotal();
                                    },
                                );
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                            console.log(error.response.data);
                            alert(error.response.data.message);
                        });
                });
        });

    $("#order-payment-btn")
        .off("click")
        .on("click", function (e) {
            e.preventDefault();
            if ($("#order-payment-btn").hasClass("hidden")) {
                return;
            }

            $("#payment-model-box").removeClass("hidden");

            // $('#payment-amount').val($('#total_price').text().replace(' Ks', ''));

            $("#payment-cancel-btn")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();
                    $("#payment-model-box").addClass("hidden");
                });

            $("#payment-confirm-btn-model")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();
                    let amountInInput = $("#payment-amount").val() || "";
                    amountInInput = amountInInput.trim();

                    if (amountInInput == "") {
                        alert("Please enter amount");
                        return;
                    }

                    const amount = Number(amountInInput);

                    let totalPrice = $("#total_price")
                        .text()
                        .replace(" Ks", "");
                    totalPrice = Number(totalPrice.replace(/,/g, ""));

                    if (amount < totalPrice) {
                        alert("Amount is less than total price");
                        $("#payment-amount").val("");
                        return;
                    }
                    let change = amount - totalPrice;

                    $("#received_price").text(amount.toLocaleString() + " Ks");
                    $("#change_price").text(change.toLocaleString() + " Ks");
                    $("#payment-confirm-btn").removeClass("hidden");
                    $("#payment-model-box").addClass("hidden");
                    $("#order-again-btn").hide();
                    $("#order-payment-btn").hide();

                    $(".qty-decrease").hide();
                    $(".qty-increase").hide();
                    $("#open-tables-btn").hide();
                });
        });

    $("#payment-confirm-btn")
        .off("click")
        .on("click", function (e) {
            e.preventDefault();
            const paymentMethod = $(
                'input[name="payment-method"]:checked',
            ).val();

            let totalPrice = $("#total_price").text().replace(" Ks", "");
            totalPrice = Number(totalPrice.replace(/,/g, ""));
            let receivedPrice = $("#received_price").text().replace(" Ks", "");
            receivedPrice = Number(receivedPrice.replace(/,/g, ""));
            let change = $("#change_price").text().replace(" Ks", "");
            change = Number(change.replace(/,/g, ""));
            let orderId = $("#order_id").attr("value") || "";
            orderId = orderId.trim();
            const payment = {
                order_id: orderId,
                payment_method: paymentMethod,
                total_price: totalPrice,
                received_price: receivedPrice,
                change_price: change,
            };

            axios
                .post("/cashier/orderPayment", payment, {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content",
                        ),
                    },
                })
                .then(function (response) {
                    if (
                        response.data.message ==
                        "Order payment placed successfully"
                    ) {
                        window.location.href =
                            "/cashier/receipt/" + response.data.order_id;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    console.log(error.response.data);
                    alert(error.response.data.message);
                });
        });
});
