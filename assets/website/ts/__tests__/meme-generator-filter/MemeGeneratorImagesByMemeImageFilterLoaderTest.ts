import { describe, expect, test } from '@jest/globals';
import MemeGeneratorImagesByMemeImageFilterLoader from '../../src/meme-generator-filter/MemeGeneratorImagesByMemeImageFilterLoader';

describe('Meme generator images by meme image filter are loaded', (): void => {
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <div class="lds-dual-ring"></div>
            <a id="xing-media-meme-image-filter-button">Test</a>
            <a id="xing-media-meme-template-filter-button">Test2</a>
        </div>`;
    });

    test('Meme generator images by meme image filter are loaded successful', (): void => {
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

        let memeGeneratorImagesByMemeImageFilterLoader: MemeGeneratorImagesByMemeImageFilterLoader =
            new MemeGeneratorImagesByMemeImageFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                'xing-media-meme-image-filter-button',
                'xing-media-meme-template-filter-button',
            );

        memeGeneratorImagesByMemeImageFilterLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorImagesByMemeImageFilterLoader.METHOD,
            MemeGeneratorImagesByMemeImageFilterLoader.URL + 0,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector(
            '.lds-dual-ring',
        ) as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('none');
        let expectedMemeImageFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeImageFilterButton.classList)).toEqual([
            'xing-media-filter-button-selected',
        ]);
        let expectedMemeTemplateFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button',
        ]);
    });
    test('response status equals 500', (): void => {
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

        let memeGeneratorImagesByMemeImageFilterLoader: MemeGeneratorImagesByMemeImageFilterLoader =
            new MemeGeneratorImagesByMemeImageFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                'xing-media-meme-image-filter-button',
                'xing-media-meme-template-filter-button',
            );

        memeGeneratorImagesByMemeImageFilterLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorImagesByMemeImageFilterLoader.METHOD,
            MemeGeneratorImagesByMemeImageFilterLoader.URL + 0,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector(
            '.lds-dual-ring',
        ) as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('flex');
        let expectedMemeImageFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeImageFilterButton.classList)).toEqual([
            'xing-media-filter-button-disabled',
        ]);
        let expectedMemeTemplateFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button-disabled',
        ]);
    });

    test('ready state equals 1', (): void => {
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

        let memeGeneratorImagesByMemeImageFilterLoader: MemeGeneratorImagesByMemeImageFilterLoader =
            new MemeGeneratorImagesByMemeImageFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                'xing-media-meme-image-filter-button',
                'xing-media-meme-template-filter-button',
            );

        memeGeneratorImagesByMemeImageFilterLoader.load();

        xhrMock.onreadystatechange();

        expect(xhrMock.open).toHaveBeenCalledWith(
            MemeGeneratorImagesByMemeImageFilterLoader.METHOD,
            MemeGeneratorImagesByMemeImageFilterLoader.URL + 0,
            true,
        );
        expect(xhrMock.send).toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector(
            '.lds-dual-ring',
        ) as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('flex');
        let expectedMemeImageFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeImageFilterButton.classList)).toEqual([
            'xing-media-filter-button-disabled',
        ]);
        let expectedMemeTemplateFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeTemplateFilterButton.classList)).toEqual([
            'xing-media-filter-button-disabled',
        ]);
    });
    test('loadingIndicator is not found', (): void => {
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

        try {
            new MemeGeneratorImagesByMemeImageFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring-wrong',
                'xing-media-meme-image-filter-button',
                'xing-media-meme-template-filter-button',
            );
        } catch (error: any) {
            expect(error.message).toBe(
                'Meme generator images by meme image filter are not loaded.',
            );
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(
            MemeGeneratorImagesByMemeImageFilterLoader.METHOD,
            MemeGeneratorImagesByMemeImageFilterLoader.URL + 0,
            true,
        );
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector(
            '.lds-dual-ring',
        ) as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('');
        let expectedMemeImageFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeImageFilterButton.classList)).toEqual([]);
        let expectedMemeTemplateFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeTemplateFilterButton.classList)).toEqual([]);
    });
    test('meme image filter button is not found', (): void => {
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

        try {
            new MemeGeneratorImagesByMemeImageFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                'xing-media-meme-image-filter-button-wrong',
                'xing-media-meme-template-filter-button',
            );
        } catch (error: any) {
            expect(error.message).toBe(
                'Meme generator images by meme image filter are not loaded.',
            );
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(
            MemeGeneratorImagesByMemeImageFilterLoader.METHOD,
            MemeGeneratorImagesByMemeImageFilterLoader.URL + 0,
            true,
        );
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector(
            '.lds-dual-ring',
        ) as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('');
        let expectedMemeImageFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeImageFilterButton.classList)).toEqual([]);
        let expectedMemeTemplateFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeTemplateFilterButton.classList)).toEqual([]);
    });
    test('meme template filter button is not found', (): void => {
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

        try {
            new MemeGeneratorImagesByMemeImageFilterLoader(
                galleryImagesManipulatorMock,
                containerAnimationInitializerMock,
                '.lds-dual-ring',
                'xing-media-meme-image-filter-button',
                'xing-media-meme-template-filter-button-wrong',
            );
        } catch (error: any) {
            expect(error.message).toBe(
                'Meme generator images by meme image filter are not loaded.',
            );
        }

        expect(xhrMock.open).not.toHaveBeenCalledWith(
            MemeGeneratorImagesByMemeImageFilterLoader.METHOD,
            MemeGeneratorImagesByMemeImageFilterLoader.URL + 0,
            true,
        );
        expect(xhrMock.send).not.toHaveBeenCalled();
        expect(galleryImagesManipulatorMock.displayImagesInGallery).not.toHaveBeenCalledWith([
            'image1.jpg',
            'image2.jpg',
        ]);
        expect(containerAnimationInitializerMock.init).not.toHaveBeenCalled();
        let expectedLoadingIndicator: HTMLElement = document.querySelector(
            '.lds-dual-ring',
        ) as HTMLElement;
        expect(Array.from(expectedLoadingIndicator.classList)).toEqual(['lds-dual-ring']);
        expect(expectedLoadingIndicator.style.display).toBe('');
        let expectedMemeImageFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-image-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeImageFilterButton.classList)).toEqual([]);
        let expectedMemeTemplateFilterButton: HTMLAnchorElement = document.getElementById(
            'xing-media-meme-template-filter-button',
        ) as HTMLAnchorElement;
        expect(Array.from(expectedMemeTemplateFilterButton.classList)).toEqual([]);
    });
});
