let address: Element = document.querySelector('.xing_address-container div a');
address.addEventListener('click', (): void => {
    if (address.textContent === 'Copied!') {
        return;
    }

    const addressText: string =  '5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump';
    address.textContent = 'Copied!';
    navigator.clipboard.writeText(addressText);
    setTimeout(function(): void {
        address.textContent = '📋 5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump';
    }, 1000);
});
