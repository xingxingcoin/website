import {describe, expect, test} from '@jest/globals';
import GalleryInfiniteScrollingImageLoader
    from '../../src/gallery-infinite-scrolling/GalleryInfiniteScrollingImageLoader';
import GalleryImagesByGifFilterLoader from '../../src/gallery-filter/GalleryImagesByGifFilterLoader';
import GalleryImagesByImageFilterLoader from '../../src/gallery-filter/GalleryImagesByImageFilterLoader';

describe('gallery infinite scrolling images are loaded', (): void => {
    let imageFilterButton: HTMLAnchorElement;
    let gifFilterButton: HTMLAnchorElement;
    let footer: HTMLElement;
    beforeEach((): void => {
       document.body.innerHTML = `<div>
            <a class="xing-media-filter-button-selected" id="xing-media-images-filter-button"></a>
            <a class="xing-media-filter-button-selected" id="xing-media-gifs-filter-button"></a>
            <footer></footer>
        </div>`;
       imageFilterButton = document.getElementById('xing-media-images-filter-button') as HTMLAnchorElement;
       gifFilterButton = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
       footer = document.querySelector('footer') as HTMLElement;
    });

    test('gallery infinite scrolling images are loaded successfully', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryInfiniteScrollingImageLoader.METHOD, GalleryInfiniteScrollingImageLoader.URL + 1, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(2);
    });

    test('url json response equals 0', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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
            response: JSON.stringify({ urls: [] }),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryInfiniteScrollingImageLoader.METHOD, GalleryInfiniteScrollingImageLoader.URL + 1, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).toHaveBeenCalledWith([]);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('response status equals 500', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryInfiniteScrollingImageLoader.METHOD, GalleryInfiniteScrollingImageLoader.URL + 1, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('ready state equals 1', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryInfiniteScrollingImageLoader.METHOD, GalleryInfiniteScrollingImageLoader.URL + 1, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('footerPosition bigger than windowHeight + 50', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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
            response: JSON.stringify({ urls: [] }),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;
        const footerRect = {
            x: 100,
        } as DOMRect;
        jest.spyOn(footer, 'getBoundingClientRect').mockReturnValue(footerRect);
        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).not.toHaveBeenCalledWith(GalleryInfiniteScrollingImageLoader.METHOD, GalleryInfiniteScrollingImageLoader.URL + 1, true);
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
    });
    test('is loading is already set to true', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        window.dispatchEvent(new Event('scroll'));
        window.dispatchEvent(new Event('scroll'));

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryInfiniteScrollingImageLoader.METHOD, GalleryInfiniteScrollingImageLoader.URL + 1, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(2);
    });
    test('imagesFilterButton is not found', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }
        try {
            new GalleryInfiniteScrollingImageLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                'xing-media-images-filter-button-wrong',
                'xing-media-gifs-filter-button',
                'footer'
            );
        } catch (error: any) {
            expect(error.message).toBe('Gallery infinite scrolling images are not loaded.');
        }
    });
    test('gifFilterButton is not found', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }
        try {
            new GalleryInfiniteScrollingImageLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                'xing-media-images-filter-button',
                'xing-media-gifs-filter-button-wrong',
                'footer'
            );
        } catch (error: any) {
            expect(error.message).toBe('Gallery infinite scrolling images are not loaded.');
        }
    });
    test('footer is not found', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
        };
        const containerAnimationInitializerMock: any = {
            init: jest.fn()
        }
        try {
            new GalleryInfiniteScrollingImageLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                'xing-media-images-filter-button',
                'xing-media-gifs-filter-button',
                'footer-wrong'
            );
        } catch (error: any) {
            expect(error.message).toBe('Gallery infinite scrolling images are not loaded.');
        }
    });
    test('resetFilter is successful', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );
        document.dispatchEvent(new Event('resetFilter'));
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
        expect(galleryInfiniteScrollingImageLoader['urlForRequest']).toBe(GalleryInfiniteScrollingImageLoader.URL);
    });
    test('afterGifFilterButtonCLicked event is successful', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );
        gifFilterButton.dispatchEvent(new Event('afterGifFilterButtonCLicked'));
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
        expect(galleryInfiniteScrollingImageLoader['urlForRequest']).toBe(GalleryImagesByGifFilterLoader.URL);
    });
    test('In afterGifFilterButtonCLicked event xing-media-filter-button-selected class is not found', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );
        gifFilterButton.classList.remove('xing-media-filter-button-selected');
        gifFilterButton.dispatchEvent(new Event('afterGifFilterButtonCLicked'));
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
        expect(galleryInfiniteScrollingImageLoader['urlForRequest']).toBe(GalleryInfiniteScrollingImageLoader.URL);
    });
    test('afterImageFilterButtonCLicked event is successful', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );
        imageFilterButton.dispatchEvent(new Event('afterImageFilterButtonCLicked'));
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
        expect(galleryInfiniteScrollingImageLoader['urlForRequest']).toBe(GalleryImagesByImageFilterLoader.URL);
    });
    test('In afterImageFilterButtonCLicked event xing-media-filter-button-selected class is not found', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn()
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

        const galleryInfiniteScrollingImageLoader = new GalleryInfiniteScrollingImageLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            'xing-media-images-filter-button',
            'xing-media-gifs-filter-button',
            'footer'
        );
        imageFilterButton.classList.remove('xing-media-filter-button-selected');
        imageFilterButton.dispatchEvent(new Event('afterGifFilterButtonCLicked'));
        expect(galleryInfiniteScrollingImageLoader['imageCounter']).toBe(1);
        expect(galleryInfiniteScrollingImageLoader['urlForRequest']).toBe(GalleryInfiniteScrollingImageLoader.URL);
    });
});
