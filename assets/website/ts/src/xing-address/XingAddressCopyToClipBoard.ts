export default class XingAddressCopyToClipBoard {
    private readonly button: Element | null;
    constructor(xingAddressButton: string) {
        this.button = document.querySelector(xingAddressButton);
        if (this.button === null) {
            return;
        }

        this.initEventListener();
    }

    private initEventListener(): void {
        (this.button as Element).addEventListener('click', (): void => {
            if ((this.button as Element).textContent === 'Copied!') {
                return;
            }

            const addressText: string = '5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump';
            (this.button as Element).textContent = 'Copied!';
            navigator.clipboard.writeText(addressText);
            setTimeout((): void => {
                (this.button as Element).textContent =
                    '📋 5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump';
            }, 1000);
        });
    }
}
