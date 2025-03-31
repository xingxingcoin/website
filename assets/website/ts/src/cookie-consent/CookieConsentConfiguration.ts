export default class CookieConsentConfiguration {
    public static getConfig(): any
    {
        return {
            categories: {
                analytics: {
                    services: {
                        dexscreener: {
                            label: 'Dexscreener Chart',
                            onAccept: (): any => {
                                const cookieContainer: Element | null = document.querySelector('.xing_information-right-container-cookie-container');
                                const dexscreenerChartInnerContainer: Element | null = document.querySelector('.xing_information-main-container .xing_information-inner-container:nth-of-type(2)');
                                if (cookieContainer === null || dexscreenerChartInnerContainer === null) {
                                    return;
                                }
                                let iframe: HTMLIFrameElement = document.createElement('iframe');
                                iframe.setAttribute('id', 'dextools-widget');
                                iframe.setAttribute('title', 'DEXTools Trading Chart');
                                iframe.setAttribute('width', '400');
                                iframe.setAttribute('height', '400');
                                iframe.setAttribute('src', 'https://www.dextools.io/widget-chart/en/solana/pe-light/2PuVkhDEQ5uprXRowUnGgFNvPFUN7PDomMgQWxYq37HV?theme=light&chartType=2&chartResolution=30&drawingToolbars=false');
                                cookieContainer.remove();
                                dexscreenerChartInnerContainer.appendChild(iframe);
                            }
                        }
                    }
                }
            },
            disablePageInteraction: true,
            language: {
                default: 'en',
                translations: {
                    en: {
                        consentModal: {
                            title: 'This website is using cookies',
                            description: 'At xingxingmemes.com we use cookies to track information about your visit. Cookies, including those from third parties, help us to improve our website and make you tailor-made offers to suit your interests. By clicking on "Accept all", you consent to such processing. Your consent is voluntary and can be revoked at any time with effect for the future.',
                            acceptAllBtn: 'Accept all',
                            acceptNecessaryBtn: 'Reject all',
                            showPreferencesBtn: 'Manage Individual preferences'
                        },
                        preferencesModal: {
                            title: 'Manage cookie preferences',
                            acceptAllBtn: 'Accept all',
                            acceptNecessaryBtn: 'Reject all',
                            savePreferencesBtn: 'Accept current selection',
                            closeIconLabel: 'Close modal',
                            sections: [
                                {
                                    title: 'Tracking and Statistics',
                                    description: 'Statistic cookies help website owners to understand how visitors interact with websites by collecting and reporting information anonymously.',
                                    linkedCategory: 'analytics'
                                }
                            ]
                        }
                    }
                }
            }
        };
    }
}
