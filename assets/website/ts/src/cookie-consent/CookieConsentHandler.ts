import * as CookieConsent from 'vanilla-cookieconsent';
import CookieConsentConfiguration from './CookieConsentConfiguration';

export default class CookieConsentHandler {
    private readonly cookiePreferenceShowButton: Element | null;
    private readonly cookieFooterPreferenceShowButton: Element | null;

    constructor(cookieConsentPreferenceSelector: string, cookieFooterPreferenceShowButtonSelector: string) {
        this.cookiePreferenceShowButton = document.querySelector(cookieConsentPreferenceSelector);
        this.cookieFooterPreferenceShowButton = document.querySelector(cookieFooterPreferenceShowButtonSelector);

        this.initEventListener();
    }

    private initEventListener(): void
    {
        document.addEventListener('DOMContentLoaded', (): void => {
            CookieConsent.run(CookieConsentConfiguration.getConfig());

            if (this.cookieFooterPreferenceShowButton === null) {
                return;
            }
            (this.cookieFooterPreferenceShowButton as Element).addEventListener('click', (): void => {
                CookieConsent.showPreferences();
            });
            if (this.cookiePreferenceShowButton === null) {
                return;
            }
            (this.cookiePreferenceShowButton as Element).addEventListener('click', (): void => {
                CookieConsent.showPreferences();
            });
        });
    }
}
