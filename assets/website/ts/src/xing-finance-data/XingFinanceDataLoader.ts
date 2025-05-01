import XingFinanceDataResponse from './types/XingFinanceDataResponse';

export default class XingFinanceDataLoader {
    static readonly URL: string = '/api/v1/finance/xing';
    static readonly METHOD: string = 'GET';

    private readonly marketCapElement: HTMLElement;
    private readonly leftToBillionElement: HTMLElement;
    private readonly gifPictureElement: HTMLElement | null;
    private readonly performanceTextElement: HTMLElement | null;

    /**
     * @throws Error
     */
    constructor(marketCapClass: string, gifClass: string, performanceTextClass: string) {
        const marketCapElements: NodeList = document.querySelectorAll(marketCapClass);
        this.gifPictureElement = document.querySelector(gifClass) as HTMLElement | null;
        this.performanceTextElement = document.querySelector(performanceTextClass) as HTMLElement | null;
        if (marketCapElements.length !== 2 ||
            this.gifPictureElement === null ||
            this.performanceTextElement === null) {
            throw new Error('Xing finance data is not loaded.');
        }

        this.marketCapElement = marketCapElements[0] as HTMLElement;
        this.leftToBillionElement = marketCapElements[1] as HTMLElement;
        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', this.load.bind(this));
    }

    public load(): void {
        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        ajaxHttpClient.onreadystatechange = (): void => {
            if (ajaxHttpClient.readyState === 4 && ajaxHttpClient.status === 200) {
                const jsonResponse: XingFinanceDataResponse = JSON.parse(ajaxHttpClient.response);
                this.displayXingMarketCap(jsonResponse);
                this.displayGif(jsonResponse);
                this.displayPerformanceText(jsonResponse);
            }
        };

        ajaxHttpClient.send();
    }

    private displayXingMarketCap(jsonResponse: XingFinanceDataResponse): void {
        this.marketCapElement.textContent = '$ ' + jsonResponse.finance.marketCap.toLocaleString('en-EN');
        this.leftToBillionElement.textContent = '$ ' + (1000000000 - jsonResponse.finance.marketCap).toLocaleString('en-EN');
    }
    private displayGif(jsonResponse: XingFinanceDataResponse): void {
        const source = (this.gifPictureElement as HTMLElement).querySelector('source') as HTMLSourceElement;
        const img = (this.gifPictureElement as HTMLElement).querySelector('img') as HTMLImageElement;
        source.srcset = jsonResponse.url;
        img.src = jsonResponse.url;
    }
    private displayPerformanceText(jsonResponse: XingFinanceDataResponse): void {
        const performanceTextSpanElement = (this.performanceTextElement as HTMLElement).querySelector('span') as HTMLSpanElement;
        if (jsonResponse.finance.priceChange >= 0) {
            performanceTextSpanElement.textContent = '+' + jsonResponse.finance.priceChange.toLocaleString('en-EN') + ' % 🐵';
        }
        if (jsonResponse.finance.priceChange < 0) {
            (this.performanceTextElement as HTMLElement).classList.remove('xing_information-right-container-price-change-positive-text');
            (this.performanceTextElement as HTMLElement).classList.add('xing_information-right-container-price-change-negative-text');
            performanceTextSpanElement.textContent = jsonResponse.finance.priceChange.toLocaleString('en-EN') + ' % 🙈';
        }
    }
}
