import * as CookieConsent from 'vanilla-cookieconsent';
import CookieConsentConfiguration from './CookieConsentConfiguration';

export default class CookieConsentHandler {
    private readonly cookiePreferenceShowButton: Element | null;

    /**
     * @exception Error
     */
    constructor(cookieConsentPreferenceSelector: string) {
        this.cookiePreferenceShowButton = document.querySelector(cookieConsentPreferenceSelector);
        if (this.cookiePreferenceShowButton === null) {
            throw new Error('Cookie Consent is not displayed.');
        }

        this.initEventListener();
    }

    private initEventListener(): void
    {
        document.addEventListener('DOMContentLoaded', (): void => {
            CookieConsent.run(CookieConsentConfiguration.getConfig());
        });

        (this.cookiePreferenceShowButton as Element).addEventListener('click', (): void => {
            CookieConsent.showPreferences();
        });
    }
}
