import {describe, expect, test} from '@jest/globals';
import CookieConsentHandler from '../../src/cookie-consent/CookieConsentHandler';
import * as CookieConsent from 'vanilla-cookieconsent';

jest.mock('vanilla-cookieconsent', (): any => ({
    run: jest.fn(),
    showPreferences: jest.fn(),
}));

describe('handle cookie consent', (): void => {
    beforeEach((): void => {
       document.body.innerHTML = `<div class="xing_information-right-container-cookie-container">
            <a>Test</a>
            <div class="xing_information-main-container">
                <div class="xing_information-inner-container"></div>
                <div class="xing_information-inner-container"></div>
            </div>
            <div class="footer-information-container">
                <a>Test</a>
            </div>
        </div>`;
    });
    test('handle cookie consent is successful', (): void => {
        new CookieConsentHandler('.xing_information-right-container-cookie-container a', '.footer-information-container a');

        document.dispatchEvent(new Event('DOMContentLoaded'));

        expect(CookieConsent.run).toHaveBeenCalled();
        expect(CookieConsent.showPreferences).not.toHaveBeenCalled();
    });

    test('cookiePreferenceShowButton is clicked', (): void => {
        let cookiePreferenceShowButton: HTMLElement = document.querySelector('.xing_information-right-container-cookie-container a') as HTMLElement;
        new CookieConsentHandler('.xing_information-right-container-cookie-container a', '.footer-information-container a');

        document.dispatchEvent(new Event('DOMContentLoaded'));
        cookiePreferenceShowButton.click();

        expect(CookieConsent.run).toHaveBeenCalled();
        expect(CookieConsent.showPreferences).toHaveBeenCalled();
    });
    test('cookiePreferenceShowButton is not found', (): void => {
        new CookieConsentHandler('.xing_information-right-container-cookie-container-wrong a', '.footer-information-container a');
        document.dispatchEvent(new Event('DOMContentLoaded'));

        expect(CookieConsent.showPreferences).not.toHaveBeenCalled();
        expect(CookieConsent.run).toHaveBeenCalled();
    });
    test('cookieFooterPreferenceShowButton is clicked', (): void => {
        let cookieFooterPreferenceShowButton: HTMLElement = document.querySelector('.footer-information-container a') as HTMLElement;
        new CookieConsentHandler('.xing_information-right-container-cookie-container a', '.footer-information-container a');

        document.dispatchEvent(new Event('DOMContentLoaded'));
        cookieFooterPreferenceShowButton.click();

        expect(CookieConsent.run).toHaveBeenCalled();
        expect(CookieConsent.showPreferences).toHaveBeenCalled();
    });
    test('cookieFooterPreferenceShowButton is not found', (): void => {
        new CookieConsentHandler('.xing_information-right-container-cookie-container a', '.footer-information-container-wrong a');
        document.dispatchEvent(new Event('DOMContentLoaded'));

        expect(CookieConsent.showPreferences).not.toHaveBeenCalled();
        expect(CookieConsent.run).toHaveBeenCalled();
    });
});
