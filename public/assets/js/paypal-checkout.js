(() => {
  'use strict';
  const container = document.querySelector('#paypal-button-container');
  const headers = {'Content-Type': 'application/json', 'X-CSRF-Token': container.dataset.csrfToken};
  const showError = (message) => {
    const box = document.querySelector('#payment-message');
    box.textContent = message; box.classList.remove('hidden'); box.classList.add('error');
  };
  const request = async (url, body = {}) => {
    const response = await fetch(url, {method: 'POST', headers, body: JSON.stringify(body)});
    const data = await response.json();
    if (!response.ok) throw new Error(data.error || 'Payment request failed');
    return data;
  };
  paypal.Buttons({
    createOrder: async () => (await request('/payments/create-order.php')).id,
    onApprove: async ({orderID}) => {
      await request('/payments/capture-order.php', {orderID});
      window.location.assign('/payments/success.php');
    },
    onError: () => showError('The payment could not be completed. Try again in a few minutes.'),
    style: {color: 'gold', shape: 'pill', label: 'pay', height: 48}
  }).render(container);
})();
