import {describe, expect, test} from '@jest/globals';
import GalleryImagesByGifFilterLoader from '../../src/gallery-filter/GalleryImagesByGifFilterLoader';

describe('Gallery images by gif filter are loaded', (): void => {
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <div class="lds-dual-ring"></div>
            <a id="xing-media-gifs-filter-button">Test</a>
            <a id="xing-media-images-filter-button">Test2</a>
        </div>`;
    });

    test('Gallery images by image filter are loaded successful', (): void => {
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
            response: JSON.stringify({urls: ['image1.jpg', 'image2.jpg']}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        let galleryImagesByGifFilterLoader: GalleryImagesByGifFilterLoader = new GalleryImagesByGifFilterLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            'xing-media-gifs-filter-button',
            'xing-media-images-filter-button'
        );

        galleryImagesByGifFilterLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryImagesByGifFilterLoader.METHOD, GalleryImagesByGifFilterLoader.URL + 0, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector('.lds-dual-ring') as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('none');
        let expectedGifFilterButton: HTMLAnchorElement = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedGifFilterButton.classList)).toEqual(['xing-media-filter-button-selected']);
        let expectedImageFilterButton: HTMLAnchorElement = document.getElementById('xing-media-images-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedImageFilterButton.classList)).toEqual(['xing-media-filter-button']);
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
            response: JSON.stringify({urls: ['image1.jpg', 'image2.jpg']}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        let galleryImagesByGifFilterLoader: GalleryImagesByGifFilterLoader = new GalleryImagesByGifFilterLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            'xing-media-gifs-filter-button',
            'xing-media-images-filter-button'
        );

        galleryImagesByGifFilterLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryImagesByGifFilterLoader.METHOD, GalleryImagesByGifFilterLoader.URL + 0, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector('.lds-dual-ring') as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('flex');
        let expectedGifFilterButton: HTMLAnchorElement = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedGifFilterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
        let expectedImageFilterButton: HTMLAnchorElement = document.getElementById('xing-media-images-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedImageFilterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
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
            response: JSON.stringify({urls: ['image1.jpg', 'image2.jpg']}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        let galleryImagesByGifFilterLoader: GalleryImagesByGifFilterLoader = new GalleryImagesByGifFilterLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            'xing-media-gifs-filter-button',
            'xing-media-images-filter-button'
        );

        galleryImagesByGifFilterLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(GalleryImagesByGifFilterLoader.METHOD, GalleryImagesByGifFilterLoader.URL + 0, true);
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector('.lds-dual-ring') as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('flex');
        let expectedGifFilterButton: HTMLAnchorElement = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedGifFilterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
        let expectedImageFilterButton: HTMLAnchorElement = document.getElementById('xing-media-images-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedImageFilterButton.classList)).toEqual(['xing-media-filter-button-disabled']);
    });
    test('loadingIndicator is not found', (): void => {
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
            response: JSON.stringify({urls: ['image1.jpg', 'image2.jpg']}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        try {
            new GalleryImagesByGifFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring-wrong',
                'xing-media-gifs-filter-button',
                'xing-media-images-filter-button'
            )
        } catch (error: any) {
            expect(error.message).toBe('Gallery images by gif filter are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(GalleryImagesByGifFilterLoader.METHOD, GalleryImagesByGifFilterLoader.URL + 0, true);
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector('.lds-dual-ring') as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('');
        let expectedGifFilterButton: HTMLAnchorElement = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedGifFilterButton.classList)).toEqual([]);
        let expectedImageFilterButton: HTMLAnchorElement = document.getElementById('xing-media-images-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedImageFilterButton.classList)).toEqual([]);
    });
    test('gif filter button is not found', (): void => {
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
            response: JSON.stringify({urls: ['image1.jpg', 'image2.jpg']}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        try {
            new GalleryImagesByGifFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                'xing-media-gifs-filter-button-wrong',
                'xing-media-images-filter-button'
            )
        } catch (error: any) {
            expect(error.message).toBe('Gallery images by gif filter are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(GalleryImagesByGifFilterLoader.METHOD, GalleryImagesByGifFilterLoader.URL + 0, true);
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector('.lds-dual-ring') as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('');
        let expectedGifFilterButton: HTMLAnchorElement = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedGifFilterButton.classList)).toEqual([]);
        let expectedImageFilterButton: HTMLAnchorElement = document.getElementById('xing-media-images-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedImageFilterButton.classList)).toEqual([]);
    });
    test('image filter button is not found', (): void => {
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
            response: JSON.stringify({urls: ['image1.jpg', 'image2.jpg']}),
            onreadystatechange: jest.fn(),
        };
        global.XMLHttpRequest = jest.fn((): XMLHttpRequest => xhrMock as unknown as XMLHttpRequest) as any;

        try {
            new GalleryImagesByGifFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                'xing-media-gifs-filter-button',
                'xing-media-images-filter-button-wrong'
            )
        } catch (error: any) {
            expect(error.message).toBe('Gallery images by gif filter are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(GalleryImagesByGifFilterLoader.METHOD, GalleryImagesByGifFilterLoader.URL + 0, true);
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith(['image1.jpg', 'image2.jpg']);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector('.lds-dual-ring') as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('');
        let expectedGifFilterButton: HTMLAnchorElement = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedGifFilterButton.classList)).toEqual([]);
        let expectedImageFilterButton: HTMLAnchorElement = document.getElementById('xing-media-images-filter-button') as HTMLAnchorElement;
        expect(Array.from(expectedImageFilterButton.classList)).toEqual([]);
    });
});
