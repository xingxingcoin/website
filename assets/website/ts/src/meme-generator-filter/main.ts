import MemeGeneratorImagesByMemeImageFilterLoadHandler from './MemeGeneratorImagesByMemeImageFilterLoadHandler';
import MemeGeneratorImagesByMemeTemplateFilterLoadHandler from './MemeGeneratorImagesByMemeTemplateFilterLoadHandler';
import MemeGeneratorImagesByMemeTemplateFilterLoader from './MemeGeneratorImagesByMemeTemplateFilterLoader';
import MemeGeneratorImagesByNoFilterLoader from './MemeGeneratorImagesByNoFilterLoader';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';
import MemeGeneratorImagesByMemeImageFilterLoader from './MemeGeneratorImagesByMemeImageFilterLoader';

new MemeGeneratorImagesByMemeImageFilterLoadHandler(
    new MemeGeneratorImagesByMemeImageFilterLoader(
        new GalleryImagesManipulator('.xing-media-container'),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-meme-image-filter-button',
        'xing-media-meme-template-filter-button',
    ),
    new MemeGeneratorImagesByNoFilterLoader(
        new GalleryImagesManipulator('.xing-media-container'),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-meme-image-filter-button',
        'xing-media-meme-template-filter-button',
    ),
    'xing-media-meme-image-filter-button',
    '.xing-media-container',
);
new MemeGeneratorImagesByMemeTemplateFilterLoadHandler(
    new MemeGeneratorImagesByMemeTemplateFilterLoader(
        new GalleryImagesManipulator('.xing-media-container'),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-meme-image-filter-button',
        'xing-media-meme-template-filter-button',
    ),
    new MemeGeneratorImagesByNoFilterLoader(
        new GalleryImagesManipulator('.xing-media-container'),
        new ContainerAnimationInitializer(),
        '.lds-dual-ring',
        'xing-media-meme-image-filter-button',
        'xing-media-meme-template-filter-button',
    ),
    'xing-media-meme-template-filter-button',
    '.xing-media-container',
);
