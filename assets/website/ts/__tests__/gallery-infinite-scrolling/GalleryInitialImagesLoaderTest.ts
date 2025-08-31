import { describe, expect, test } from '@jest/globals';
import GalleryInitialImagesLoader from '../../src/gallery-infinite-scrolling/GalleryInitialImagesLoader';

describe('gallery initial images are loaded', (): void => {
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
    test('gallery initial images are loaded is successful', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn(),
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

        new GalleryInitialImagesLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            '.xing-media-filter-button-disabled',
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            GalleryInitialImagesLoader.METHOD,
            GalleryInitialImagesLoader.URL,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        expect(loadingIndicator.style.display).toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual(['xing-media-filter-button']);
        });
    });
    test('respnse status is 500', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn(),
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

        new GalleryInitialImagesLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            '.xing-media-filter-button-disabled',
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            GalleryInitialImagesLoader.METHOD,
            GalleryInitialImagesLoader.URL,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual([
                'xing-media-filter-button-disabled',
            ]);
        });
    });
    test('ready state is equals to 1', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn(),
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

        new GalleryInitialImagesLoader(
            galleryImagesManipulatorMock,
            containerAnimationInitializerMock,
            '.lds-dual-ring',
            '.xing-media-filter-button-disabled',
        );

        document.dispatchEvent(new Event('DOMContentLoaded'));
        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            GalleryInitialImagesLoader.METHOD,
            GalleryInitialImagesLoader.URL,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
        Array.from(filterButtons).forEach((filterButton: any): void => {
            expect(Array.from(filterButton.classList)).toEqual([
                'xing-media-filter-button-disabled',
            ]);
        });
    });
    test('filter buttons are not found', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn(),
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

        document.body.innerHTML = `<div>
            <div class="lds-dual-ring"></div>
        </div>`;

        try {
            new GalleryInitialImagesLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                '.xing-media-filter-button-disabled',
            );
        } catch (error: any) {
            expect(error.message).toBe('Gallery initial images are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(
            GalleryInitialImagesLoader.METHOD,
            GalleryInitialImagesLoader.URL,
            true,
        );
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
    });
    test('loading indicator is not found', (): void => {
        const galleryImagesManipulatorMock: any = {
            displayImagesInGallery: jest.fn(),
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

        document.body.innerHTML = `<div>
            <button class="xing-media-filter-button-disabled">Test</button>
            <button class="xing-media-filter-button-disabled">Test2</button>
        </div>`;

        try {
            new GalleryInitialImagesLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                '.xing-media-filter-button-disabled',
            );
        } catch (error: any) {
            expect(error.message).toBe('Gallery initial images are not loaded.');
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(
            GalleryInitialImagesLoader.METHOD,
            GalleryInitialImagesLoader.URL,
            true,
        );
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        expect(loadingIndicator.style.display).not.toBe('none');
    });
});
