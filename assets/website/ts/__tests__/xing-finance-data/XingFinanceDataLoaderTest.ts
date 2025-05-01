import {describe, expect, test} from '@jest/globals';
import XingFinanceDataLoader from '../../src/xing-finance-data/XingFinanceDataLoader';

describe('Xing finance data is loaded.', (): void => {
    beforeEach((): void => {
        document.body.innerHTML = `<div class="xing_information-inner-container"><p class="xing_information-left-container-market-cap-text"><span>$ 0</span></p>
            <p class="xing_information-left-container-market-cap-text"><span>$ 0</span></p>
            <picture>
                <source srcset="/default.webp" type="image/webp">
                <img src="/default.gif" />
            </picture>
            <p class="xing_information-right-container-price-change-positive-text"><span>0 % 🐵</span></p>
            </div>`;
    });

    test('Xing finance data is loaded successful.', (): void => {
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({url: '/mock/path/to/image.gif', finance: {marketCap: 100000, priceChange: 2.5}}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        let xingFinanceDataLoader: XingFinanceDataLoader = new XingFinanceDataLoader(
            '.xing_information-left-container-market-cap-text span',
            '.xing_information-inner-container picture',
            '.xing_information-right-container-price-change-positive-text'
        );

        xingFinanceDataLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        expect(xhrMock.send).toHaveBeenCalled();
        const capSpans = document.querySelectorAll('.xing_information-left-container-market-cap-text span');
        const sourceElement = document.querySelector('.xing_information-inner-container picture source');
        const imgElement = document.querySelector('.xing_information-inner-container picture img');
        const performanceTextElement = document.querySelector('.xing_information-right-container-price-change-positive-text span');
        expect(capSpans[0].textContent).toBe('$ 100,000');
        expect(capSpans[1].textContent).toBe('$ 999,900,000');
        const expectedResponse = {
            finance: {
                marketCap: 355976,
                priceChange: 2.5
            },
            url: '/mock/path/to/image.gif'
        };

        expect(sourceElement?.getAttribute('srcset')).toBe(expectedResponse.url);
        expect(imgElement?.getAttribute('src')).toBe(expectedResponse.url);
        expect(performanceTextElement?.textContent).toBe('+2.5 % 🐵');
    });

    test('Xing finance data is loaded successful with negative performance text.', (): void => {
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({url: '/mock/path/to/image.gif', finance: {marketCap: 100000, priceChange: -2.5}}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        let xingFinanceDataLoader: XingFinanceDataLoader = new XingFinanceDataLoader(
            '.xing_information-left-container-market-cap-text span',
            '.xing_information-inner-container picture',
            '.xing_information-right-container-price-change-positive-text'
        );

        xingFinanceDataLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        expect(xhrMock.send).toHaveBeenCalled();
        const capSpans = document.querySelectorAll('.xing_information-left-container-market-cap-text span');
        const sourceElement = document.querySelector('.xing_information-inner-container picture source');
        const imgElement = document.querySelector('.xing_information-inner-container picture img');
        const performanceTextElement = document.querySelector('.xing_information-right-container-price-change-negative-text span');
        expect(capSpans[0].textContent).toBe('$ 100,000');
        expect(capSpans[1].textContent).toBe('$ 999,900,000');
        const expectedResponse = {
            finance: {
                marketCap: 355976,
                priceChange: -2.5
            },
            url: '/mock/path/to/image.gif'
        };

        expect(sourceElement?.getAttribute('srcset')).toBe(expectedResponse.url);
        expect(imgElement?.getAttribute('src')).toBe(expectedResponse.url);
        expect(performanceTextElement?.textContent).toBe('-2.5 % 🙈');
    });
    test('Xing finance data is not loaded successfully with status 500.', (): void => {
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 500,
            response: JSON.stringify({url: '/mock/path/to/image.gif', finance: {marketCap: 100000, priceChange: 2.5}}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        let xingFinanceDataLoader: XingFinanceDataLoader = new XingFinanceDataLoader(
            '.xing_information-left-container-market-cap-text span',
            '.xing_information-inner-container picture',
            '.xing_information-right-container-price-change-positive-text'
        );

        xingFinanceDataLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        expect(xhrMock.send).toHaveBeenCalled();
        const capSpans = document.querySelectorAll('.xing_information-left-container-market-cap-text span');
        const sourceElement = document.querySelector('.xing_information-inner-container picture source');
        const imgElement = document.querySelector('.xing_information-inner-container picture img');
        const performanceTextElement = document.querySelector('.xing_information-right-container-price-change-positive-text span');
        expect(capSpans[0].textContent).toBe('$ 0');
        expect(capSpans[1].textContent).toBe('$ 0');

        expect(sourceElement?.getAttribute('srcset')).toBe('/default.webp');
        expect(imgElement?.getAttribute('src')).toBe('/default.gif');
        expect(performanceTextElement?.textContent).toBe('0 % 🐵');
    });
    test('Xing finance data is not loaded successfully with readyState 1.', (): void => {
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 1,
            status: 200,
            response: JSON.stringify({url: '/mock/path/to/image.gif', finance: {marketCap: 100000, priceChange: 2.5}}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        let xingFinanceDataLoader: XingFinanceDataLoader = new XingFinanceDataLoader(
            '.xing_information-left-container-market-cap-text span',
            '.xing_information-inner-container picture',
            '.xing_information-right-container-price-change-positive-text'
        );

        xingFinanceDataLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        expect(xhrMock.send).toHaveBeenCalled();
        const capSpans = document.querySelectorAll('.xing_information-left-container-market-cap-text span');
        const sourceElement = document.querySelector('.xing_information-inner-container picture source');
        const imgElement = document.querySelector('.xing_information-inner-container picture img');
        const performanceTextElement = document.querySelector('.xing_information-right-container-price-change-positive-text span');
        expect(capSpans[0].textContent).toBe('$ 0');
        expect(capSpans[1].textContent).toBe('$ 0');

        expect(sourceElement?.getAttribute('srcset')).toBe('/default.webp');
        expect(imgElement?.getAttribute('src')).toBe('/default.gif');
        expect(performanceTextElement?.textContent).toBe('0 % 🐵');
    });
    test('market cap elements are not found.', (): void => {
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({url: '/mock/path/to/image.gif', finance: {marketCap: 100000, priceChange: 2.5}}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        try {
            new XingFinanceDataLoader(
                '.xing_information-left-container-market-cap-text-wrong span',
                '.xing_information-inner-container picture',
                '.xing_information-right-container-price-change-positive-text'
            );
        } catch (error: any) {
            expect(error.message).toBe('Xing finance data is not loaded.');
        }

        xhrMock.onreadystatechange();

        expect(xhrMock.open).not.toHaveBeenCalledWith(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        expect(xhrMock.send).not.toHaveBeenCalled();
    });
    test('gif picture element is not found.', (): void => {
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({url: '/mock/path/to/image.gif', finance: {marketCap: 100000, priceChange: 2.5}}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        try {
            new XingFinanceDataLoader(
                '.xing_information-left-container-market-cap-text span',
                '.xing_information-inner-container-wrong picture',
                '.xing_information-right-container-price-change-positive-text'
            );
        } catch (error: any) {
            expect(error.message).toBe('Xing finance data is not loaded.');
        }

        xhrMock.onreadystatechange();

        expect(xhrMock.open).not.toHaveBeenCalledWith(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        expect(xhrMock.send).not.toHaveBeenCalled();
    });
    test('performance text element is not found.', (): void => {
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({url: '/mock/path/to/image.gif', finance: {marketCap: 100000, priceChange: 2.5}}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        try {
            new XingFinanceDataLoader(
                '.xing_information-left-container-market-cap-text span',
                '.xing_information-inner-container picture',
                '.xing_information-right-container-price-change-positive-text-wrong'
            );
        } catch (error: any) {
            expect(error.message).toBe('Xing finance data is not loaded.');
        }

        xhrMock.onreadystatechange();

        expect(xhrMock.open).not.toHaveBeenCalledWith(XingFinanceDataLoader.METHOD, XingFinanceDataLoader.URL, true);
        expect(xhrMock.send).not.toHaveBeenCalled();
    });
});
