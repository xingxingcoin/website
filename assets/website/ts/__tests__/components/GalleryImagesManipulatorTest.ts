import {describe, expect, test} from '@jest/globals';
import GalleryImagesManipulator from "../../src/components/GalleryImagesManipulator";
import MediaUrl from "../../src/meme-generator-infinite-scrolling/types/MediaUrl";

describe('Gallery images are manipulated', (): void => {
    beforeEach((): void => {
       document.body.innerHTML = `<div class="xing-media-container"></div>`;
    });
    test('Gallery images are manipulated successful', (): void => {
        let jsonResponse: MediaUrl[] = [
            {
                imageViewerUrl: 'test',
                mediaUrl: 'test'
            },
            {
                imageViewerUrl: 'test2',
                mediaUrl: 'test2'
            }
        ];
        let galleryImagesManipulator: GalleryImagesManipulator = new GalleryImagesManipulator('.xing-media-container');
        galleryImagesManipulator.displayImagesInGallery(jsonResponse);

        const expectedGalleryContainer: Element = document.querySelector('.xing-media-container') as Element;
        expect(expectedGalleryContainer.innerHTML.replace(/\s+/g, '')).toBe('<aclass="container-bottom-hidden"href="test"><divclass="xing-image-container"><imgsrc="test"alt="ImageofXing"></div></a><aclass="container-bottom-hidden"href="test2"><divclass="xing-image-container"><imgsrc="test2"alt="ImageofXing"></div></a>');
    });
    test('Gallery images are manipulated successful', (): void => {
        let jsonResponse: MediaUrl[] = [
            {
                imageViewerUrl: 'test',
                mediaUrl: 'test'
            },
            {
                imageViewerUrl: 'test2',
                mediaUrl: 'test2'
            }
        ];

        try {
            new GalleryImagesManipulator('.xing-media-container-wrong');
        } catch (error: any) {
            expect(error.message).toBe('Gallery images could not be manipulated.');
        }

        const expectedGalleryContainer: Element = document.querySelector('.xing-media-container') as Element;
        expect(expectedGalleryContainer.innerHTML.replace(/\s+/g, '')).toBe('');
    });
});
