import {describe, expect, test} from '@jest/globals';
import MemeGeneratorInitialImagesLoader
    from '../../src/meme-generator-infinite-scrolling/MemeGeneratorInitialImagesLoader';

describe('meme generator initial images are loaded', (): void => {
    let loadingIndicator: HTMLElement;
    let filterButtons: NodeList;

    beforeEach((): void => {
       document.body.innerHTML = `<div>
            <div class="lds-dual-ring"></div>
            <button class="xing-media-filter-button-disabled">Test</button>
            <button class="xing-media-filter-button-disabled">Test2</button>
        </div>`;

       loadingIndicator = document.querySelector('.lds-dual-ring') as HTMLElement;
       filterButtons = document.querySelectorAll('.xing-media-filter-button-disabled') as NodeList;
    });
    test('meme generator initial images are loaded successfully', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        new MemeGeneratorInitialImagesLoader(
            memeGeneratorImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            '.xing-media-filter-button-disabled'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(MemeGeneratorInitialImagesLoader.METHOD, MemeGeneratorInitialImagesLoader.URL, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(loadingIndicator.style.display).toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual(['xing-media-filter-button']);
        });
    });
    test('api request has status 500', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 500,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        new MemeGeneratorInitialImagesLoader(
            memeGeneratorImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            '.xing-media-filter-button-disabled'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith('GET', '/api/v1/meme-generator/images?counter=0', true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
        });
    });
    test('ready status is 1', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }
        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 1,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        new MemeGeneratorInitialImagesLoader(
            memeGeneratorImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            '.xing-media-filter-button-disabled'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith('GET', '/api/v1/meme-generator/images?counter=0', true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
        });
    });
    test('loadingIndicator is equals to null', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }


        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 1,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        try {
            new MemeGeneratorInitialImagesLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring-wrong',
                '.xing-media-filter-button-disabled'
            );
        } catch(error: any) {
            expect(error.message).toBe('Meme generator initial images are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith('GET', '/api/v1/meme-generator/images?counter=0', true);
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
        });
    });
    test('filter buttons are not found', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 1,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        document.body.innerHTML = `<div>
            <div class="lds-dual-ring"></div>
        </div>`;

        try {
            new MemeGeneratorInitialImagesLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring-wrong',
                '.xing-media-filter-button-disabled'
            );
        } catch(error: any) {
            expect(error.message).toBe('Meme generator initial images are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith('GET', '/api/v1/meme-generator/images?counter=0', true);
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
        });
    });
});
