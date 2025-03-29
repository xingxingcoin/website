import GalleryImagesByGifFilterLoadHandler from './GalleryImagesByGifFilterLoadHandler';
import GalleryImagesByImageFilterLoadHandler from './GalleryImagesByImageFilterLoadHandler';
import GalleryImagesByImageFilterLoader from './GalleryImagesByImageFilterLoader';
import GalleryImagesByNoFilterLoader from './GalleryImagesByNoFilterLoader';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';
import GalleryImagesByGifFilterLoader from './GalleryImagesByGifFilterLoader';

new GalleryImagesByGifFilterLoadHandler(
    new GalleryImagesByGifFilterLoader(
        new GalleryImagesManipulator(),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-gifs-filter-button',
        'xing-media-images-filter-button'
    ),
    new GalleryImagesByNoFilterLoader(
        new GalleryImagesManipulator(),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-gifs-filter-button',
        'xing-media-images-filter-button'
    ),
    'xing-media-gifs-filter-button',
    '.xing-media-container'
);
new GalleryImagesByImageFilterLoadHandler(
    new GalleryImagesByImageFilterLoader(
        new GalleryImagesManipulator(),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-gifs-filter-button',
        'xing-media-images-filter-button'
    ),
    new GalleryImagesByNoFilterLoader(
        new GalleryImagesManipulator(),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-gifs-filter-button',
        'xing-media-images-filter-button'
    ),
    'xing-media-images-filter-button',
    '.xing-media-container'
);
