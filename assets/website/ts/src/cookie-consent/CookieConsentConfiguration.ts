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
                            title: 'We use cookies',
                            description: 'This website uses cookies and other tracking technologies to improve your browsing experience for the following purposes: to enable basic functionality of the website, to provide a better experience on the website, to measure your interest in our products and services and to personalize marketing interactions, to deliver ads that are more relevant to you.',
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
                                    title: 'Tracking and Performance',
                                    description: 'These cookies are used to collect information to analyze the traffic to our website and how visitors are using our website.',
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
