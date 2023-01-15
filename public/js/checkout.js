// This is your test publishable API key.
const stripe = Stripe(stripe_key);

let elements;
let clientSecretValue = null;

loadStripeElement();
checkStatus();

document
    .getElementById("payment-form")
    .addEventListener("submit", handleSubmit); //

// Fetches a payment intent and captures the client secret
async function loadStripeElement() {
    var coupon_code = $("#txtCouponCode").val();

    var data = {
        _token,
        buy_now_mode,
        coupon_code,
    };
    const { clientSecret } = await fetch(payment_intent_route, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": _token,
        },
        body: JSON.stringify(data),
    }).then((r) => r.json());

    clientSecretValue = clientSecret;

    elements = stripe.elements({
        clientSecret: clientSecret,
        loader: "always",
    });

    const paymentElement = elements.create("payment", {
        fields: { billingDetails: "never" },
    });
    paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
    e.preventDefault();

    setLoading(true);

    var coupon_code = $("#txtCouponCode").val();
    const obj = {
        _token,
        buy_now_mode,
        coupon_code,
    };

    const response = await fetch(place_order_route, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": _token,
        },
        body: JSON.stringify(obj),
    }).then((res) => res.json());

    if (response.ok) {
        const returnValue = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: finish_page,
                payment_method_data: {
                    billing_details: {
                        address: {
                            city: $("#city").val(),
                            country: $("#country").val(),
                            line1: $("#address1").val(),
                            line2: $("#address2").val(),
                            postal_code: $("#zipcode").val(),
                            state: $("#state").val(),
                        },
                        email: $("#email").val(),
                        name: $("#name").val(),
                        phone: $("#phonenumber").val(),
                    },
                },
            },
        });

        const error = returnValue.error;

        // This point will only be reached if there is an immediate error when
        // confirming the payment. Otherwise, your customer will be redirected to
        // your `return_url`. For some payment methods like iDEAL, your customer will
        // be redirected to an intermediate site first to authorize the payment, then
        // redirected to the `return_url`.
        if (
            error.type === "card_error" ||
            error.type === "validation_error" ||
            error.type === "invalid_request_error"
        ) {
            showMessage(error.message);
        } else {
            showMessage("An unexpected error occurred.");
        }

        // await fetch(order_cancel_route, {
        //   method: "DELETE",
        //   headers: {
        //     'Content-Type': 'application/json',
        //     'X-CSRF-TOKEN': _token
        //   },
        //   body: JSON.stringify({ buy_now_mode, error })
        // });
    } else {
        showMessage("Something went wrong.\n" + response.error);
    }

    setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = clientSecretValue;

    if (!clientSecret) {
        return;
    }

    console.log(clientSecret);

    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

    console.log(paymentIntent);

    switch (paymentIntent.status) {
        case "succeeded":
            window.location.replace(finish_page);
            break;
        case "processing":
            showMessage("Your payment is processing.");
            break;
        case "requires_payment_method":
            showMessage("Your payment was not successful, please try again.");
            break;
        default:
            showMessage("Something went wrong.");
            break;
    }
}

// ------- UI helpers -------

function showMessage(messageText) {
    const messageContainer = document.querySelector("#payment-message");

    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;

    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageText.textContent = "";
    }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
    }
}
