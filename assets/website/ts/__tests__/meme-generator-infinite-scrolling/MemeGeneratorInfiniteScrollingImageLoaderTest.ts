import { describe, expect, test } from '@jest/globals';
import MemeGeneratorInfiniteScrollingImageLoader from '../../src/meme-generator-infinite-scrolling/MemeGeneratorInfiniteScrollingImageLoader';

describe('meme generator infinite scrolling images are loaded', (): void => {
    let footer: HTMLElement;
    beforeEach((): void => {
        document.body.innerHTML = '<footer></footer>';
        footer = document.querySelector('footer') as HTMLElement;
    });
    test('meme generator infinite scrolling images are loaded successfully', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn(),
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn(),
        };

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn(
            (): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest,
        ) as any;

        const memeGeneratorInfiniteScrollingImageLoader =
            new MemeGeneratorInfiniteScrollingImageLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
            );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorInfiniteScrollingImageLoader.METHOD,
            MemeGeneratorInfiniteScrollingImageLoader.URL + 1,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(
            memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator,
        ).toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(memeGeneratorInfiniteScrollingImageLoader['imageCounter']).toBe(2);
    });
    test('url length equals to 0', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn(),
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn(),
        };

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({ urls: [] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn(
            (): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest,
        ) as any;

        const memeGeneratorInfiniteScrollingImageLoader =
            new MemeGeneratorInfiniteScrollingImageLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
            );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorInfiniteScrollingImageLoader.METHOD,
            MemeGeneratorInfiniteScrollingImageLoader.URL + 1,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(
            memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator,
        ).toHaveBeenCalledWith([]);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(memeGeneratorInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('response status 500', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn(),
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn(),
        };

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 500,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn(
            (): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest,
        ) as any;

        const memeGeneratorInfiniteScrollingImageLoader =
            new MemeGeneratorInfiniteScrollingImageLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
            );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorInfiniteScrollingImageLoader.METHOD,
            MemeGeneratorInfiniteScrollingImageLoader.URL + 1,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(
            memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator,
        ).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(memeGeneratorInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('ready state equals to 1', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn(),
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn(),
        };

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 1,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn(
            (): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest,
        ) as any;

        const memeGeneratorInfiniteScrollingImageLoader =
            new MemeGeneratorInfiniteScrollingImageLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
            );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorInfiniteScrollingImageLoader.METHOD,
            MemeGeneratorInfiniteScrollingImageLoader.URL + 1,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(
            memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator,
        ).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(memeGeneratorInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('footerPosition bigger than windowHeight + 50', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn(),
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn(),
        };

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn(
            (): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest,
        ) as any;
        const footerRect = {
            x: 100,
        } as DOMRect;
        jest.spyOn(footer, 'getBoundingClientRect').mockReturnValue(footerRect);
        const memeGeneratorInfiniteScrollingImageLoader =
            new MemeGeneratorInfiniteScrollingImageLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
            );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).not.toHaveBeenCalledWith(
            MemeGeneratorInfiniteScrollingImageLoader.METHOD,
            MemeGeneratorInfiniteScrollingImageLoader.URL + 1,
            true,
        );
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(
            memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator,
        ).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(memeGeneratorInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('footer is not found', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn(),
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn(),
        };

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn(
            (): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest,
        ) as any;
        footer.remove();
        const memeGeneratorInfiniteScrollingImageLoader =
            new MemeGeneratorInfiniteScrollingImageLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
            );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).not.toHaveBeenCalledWith(
            MemeGeneratorInfiniteScrollingImageLoader.METHOD,
            MemeGeneratorInfiniteScrollingImageLoader.URL + 1,
            true,
        );
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(
            memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator,
        ).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(memeGeneratorInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('is loading is already equals to true by scrolling', (): void => {
        const memeGeneratorImagesManipulatorMock: any = {
            displayImagesInMemeGenerator: jest.fn(),
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn(),
        };

        const xhrMock = {
            open: jest.fn(),
            send: jest.fn(),
            setRequestHeader: jest.fn(),
            readyState: 4,
            status: 200,
            response: JSON.stringify({ urls: ['image1.jpg', 'image2.jpg'] }),
            onreadystatechange: jest.fn(),
        };

        global.XMLHttpRequest = jest.fn(
            (): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest,
        ) as any;
        const memeGeneratorInfiniteScrollingImageLoader =
            new MemeGeneratorInfiniteScrollingImageLoader(
                memeGeneratorImagesManipulatorMock,
                containerAnimationInitializerMock,
            );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorInfiniteScrollingImageLoader.METHOD,
            MemeGeneratorInfiniteScrollingImageLoader.URL + 1,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(
            memeGeneratorImagesManipulatorMock.displayImagesInMemeGenerator,
        ).toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(memeGeneratorInfiniteScrollingImageLoader['imageCounter']).toBe(2);
    });
});
