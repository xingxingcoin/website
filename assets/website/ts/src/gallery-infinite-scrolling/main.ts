import GalleryInitialImagesLoader from './GalleryInitialImagesLoader';
import GalleryInfiniteScrollingImageLoader from './GalleryInfiniteScrollingImageLoader';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

new GalleryInitialImagesLoader(
    new GalleryImagesManipulator(),
    new ContainerAnimationInitializer(),
    '.lds-dual-ring',
    '.xing-media-filter-button-disabled'
);
new GalleryInfiniteScrollingImageLoader(
    new GalleryImagesManipulator(),
    new ContainerAnimationInitializer(),
    'xing-media-images-filter-button',
    'xing-media-gifs-filter-button',
    'footer'
);
