import MemeGeneratorInitialImagesLoader from './MemeGeneratorInitialImagesLoader';
import MemeGeneratorInfiniteScrollingImageLoader from './MemeGeneratorInfiniteScrollingImageLoader';
import MemeGeneratorImagesManipulator from "./MemeGeneratorImagesManipulator";
import ContainerAnimationInitializer from "../components/ContainerAnimationInitializer";

new MemeGeneratorInitialImagesLoader(
    new MemeGeneratorImagesManipulator('.xing-media-container'),
    new ContainerAnimationInitializer(),
    '.lds-dual-ring'
);
new MemeGeneratorInfiniteScrollingImageLoader(
    new MemeGeneratorImagesManipulator('.xing-media-container'),
    new ContainerAnimationInitializer(),
);
