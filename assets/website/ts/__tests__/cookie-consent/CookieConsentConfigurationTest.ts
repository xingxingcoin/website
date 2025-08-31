import { describe, expect, test } from '@jest/globals';
import CookieConsentConfiguration from '../../src/cookie-consent/CookieConsentConfiguration';

describe('configure cookie consent', (): void => {
    beforeEach((): void => {
        document.body.innerHTML = `<div class="xing_information-main-container">
            <div class="xing_information-inner-container"></div>
            <div class="xing_information-inner-container">
                <div class="xing_information-right-container-cookie-container"></div>
            </div>
        </div>`;
    });
    test('configure cookie consent is successful', (): void => {
        const cookieConsentConfiguration: any = CookieConsentConfiguration.getConfig();
        const onAccept: any =
            cookieConsentConfiguration.categories.analytics.services.dexscreener.onAccept;
        onAccept();
        const expectedMainContainer: Element = document.querySelector(
            '.xing_information-main-container',
        ) as Element;
        expect(expectedMainContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<divclass="xing_information-inner-container"></div><divclass="xing_information-inner-container"><iframeid="dextools-widget"title="DEXToolsTradingChart"width="400"height="400"src="https://www.dextools.io/widget-chart/en/solana/pe-light/2PuVkhDEQ5uprXRowUnGgFNvPFUN7PDomMgQWxYq37HV?theme=light&amp;chartType=2&amp;chartResolution=30&amp;drawingToolbars=false"></iframe></div>',
        );
    });

    test('cookieContainer is not found', (): void => {
        const cookieConsentConfiguration: any = CookieConsentConfiguration.getConfig();
        document.body.innerHTML = `<div class="xing_information-main-container">
            <div class="xing_information-inner-container"></div>
            <div class="xing_information-inner-container">
            </div>
        </div>`;
        const onAccept: any =
            cookieConsentConfiguration.categories.analytics.services.dexscreener.onAccept;
        onAccept();
        const expectedMainContainer: Element = document.querySelector(
            '.xing_information-main-container',
        ) as Element;
        expect(expectedMainContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<divclass="xing_information-inner-container"></div><divclass="xing_information-inner-container"></div>',
        );
    });
    test('dexscreenerChartInnerContainer is not found', (): void => {
        const cookieConsentConfiguration: any = CookieConsentConfiguration.getConfig();
        document.body.innerHTML = `<div class="xing_information-main-container">
                <div class="xing_information-right-container-cookie-container"></div>
        </div>`;
        const onAccept: any =
            cookieConsentConfiguration.categories.analytics.services.dexscreener.onAccept;
        onAccept();
        const expectedMainContainer: Element = document.querySelector(
            '.xing_information-main-container',
        ) as Element;
        expect(expectedMainContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<divclass="xing_information-right-container-cookie-container"></div>',
        );
    });
});
