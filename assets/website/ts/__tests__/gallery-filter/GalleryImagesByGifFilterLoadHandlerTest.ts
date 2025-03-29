import {describe, expect, test} from '@jest/globals';
import GalleryImagesByGifFilterLoadHandler from '../../src/gallery-filter/GalleryImagesByGifFilterLoadHandler';

describe('Gallery images by gif filter loaded', (): void => {
    let gifFilterButton: HTMLAnchorElement;
    beforeEach((): void => {
       document.body.innerHTML = `<div>
            <a id="xing-media-gifs-filter-button" class="xing-media-filter-button"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;

        gifFilterButton = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
    });

    test('Gallery images by gif filter loaded successful', (): void => {
        let galleryImagesByGifFilterLoaderMock: any = {
            load: jest.fn()
        };
        let galleryImagesByNoFilterLoaderMock: any = {
            load: jest.fn()
        };
        new GalleryImagesByGifFilterLoadHandler(
            galleryImagesByGifFilterLoaderMock,
            galleryImagesByNoFilterLoaderMock,
            'xing-media-gifs-filter-button',
            '.xing-media-container'
        );

        gifFilterButton.click();

        expect(galleryImagesByGifFilterLoaderMock.load).toHaveBeenCalled();
        expect(galleryImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector('.xing-media-container') as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe('<divclass="lds-dual-ring"></div>');
    });

    test('Gallery images by no filter loaded successful', (): void => {
        let galleryImagesByGifFilterLoaderMock: any = {
            load: jest.fn()
        };
        let galleryImagesByNoFilterLoaderMock: any = {
            load: jest.fn()
        };
        document.body.innerHTML = `<div>
            <a id="xing-media-gifs-filter-button"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;
        gifFilterButton = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        new GalleryImagesByGifFilterLoadHandler(
            galleryImagesByGifFilterLoaderMock,
            galleryImagesByNoFilterLoaderMock,
            'xing-media-gifs-filter-button',
            '.xing-media-container'
        );

        gifFilterButton.click();

        expect(galleryImagesByGifFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(galleryImagesByNoFilterLoaderMock.load).toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector('.xing-media-container') as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe('<divclass="lds-dual-ring"></div>');
    });

    test('gif filter button contains disabled class', (): void => {
        let galleryImagesByGifFilterLoaderMock: any = {
            load: jest.fn()
        };
        let galleryImagesByNoFilterLoaderMock: any = {
            load: jest.fn()
        };
        document.body.innerHTML = `<div>
            <a id="xing-media-gifs-filter-button" class="xing-media-filter-button-disabled"></a>
            <div class="xing-media-container">
                <img id="example1">
                <div class="lds-dual-ring"></div>
                <img id="example2">
            </div>
        </div>`;
        gifFilterButton = document.getElementById('xing-media-gifs-filter-button') as HTMLAnchorElement;
        new GalleryImagesByGifFilterLoadHandler(
            galleryImagesByGifFilterLoaderMock,
            galleryImagesByNoFilterLoaderMock,
            'xing-media-gifs-filter-button',
            '.xing-media-container'
        );

        gifFilterButton.click();

        expect(galleryImagesByGifFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(galleryImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector('.xing-media-container') as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe('<imgid="example1"><divclass="lds-dual-ring"></div><imgid="example2">');
    });
    test('gifFilterButton is not found', (): void => {
        let galleryImagesByGifFilterLoaderMock: any = {
            load: jest.fn()
        };
        let galleryImagesByNoFilterLoaderMock: any = {
            load: jest.fn()
        };

        try {
            new GalleryImagesByGifFilterLoadHandler(
                galleryImagesByGifFilterLoaderMock,
                galleryImagesByNoFilterLoaderMock,
                'xing-media-gifs-filter-button-wrong',
                '.xing-media-container'
            );
        } catch (error: any) {
            expect(error.message).toBe('Gallery images by gif filter not loaded.')
        }

        expect(galleryImagesByGifFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(galleryImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector('.xing-media-container') as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe('<imgid="example1"><divclass="lds-dual-ring"></div><imgid="example2">');
    });
    test('mediaContainer is not found', (): void => {
        let galleryImagesByGifFilterLoaderMock: any = {
            load: jest.fn()
        };
        let galleryImagesByNoFilterLoaderMock: any = {
            load: jest.fn()
        };

        try {
            new GalleryImagesByGifFilterLoadHandler(
                galleryImagesByGifFilterLoaderMock,
                galleryImagesByNoFilterLoaderMock,
                'xing-media-gifs-filter-button',
                '.xing-media-container-wrong'
            );
        } catch (error: any) {
            expect(error.message).toBe('Gallery images by gif filter not loaded.')
        }

        expect(galleryImagesByGifFilterLoaderMock.load).not.toHaveBeenCalled();
        expect(galleryImagesByNoFilterLoaderMock.load).not.toHaveBeenCalled();
        const expectedMediaContainer: Element = document.querySelector('.xing-media-container') as Element;
        expect(expectedMediaContainer.innerHTML.replace(/\s+/g, '')).toBe('<imgid="example1"><divclass="lds-dual-ring"></div><imgid="example2">');
    });
});
