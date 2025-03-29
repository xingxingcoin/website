import {describe, expect, test} from '@jest/globals';
import MemeGeneratorInitialImagesLoader
    from '../../src/meme-generator-infinite-scrolling/MemeGeneratorInitialImagesLoader';

describe('meme generator initial images are loaded', (): void => {
    let loadingIndicator: HTMLElement;

    beforeEach((): void => {
       document.body.innerHTML = `<div>
            <div class="lds-dual-ring"></div>
        </div>`;

       loadingIndicator = document.querySelector('.lds-dual-ring') as HTMLElement;
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
            '.lds-dual-ring'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(MemeGeneratorInitialImagesLoader.METHOD, MemeGeneratorInitialImagesLoader.URL, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(loadingIndicator.style.display).toBe('none');
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
            '.lds-dual-ring'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith('GET', '/api/v1/meme-generator/images?counter=0', true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
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
            '.lds-dual-ring'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith('GET', '/api/v1/meme-generator/images?counter=0', true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
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
                '.lds-dual-ring-wrong'
            );
        } catch(error: any) {
            expect(error.message).toBe('Meme generator initial images are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith('GET', '/api/v1/meme-generator/images?counter=0', true);
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
    });
});
