<?php

declare(strict_types=1);

namespace Phel\Build\Compile;

use Phel\Build\Extractor\NamespaceExtractorInterface;

final class ProjectCompiler
{
    private NamespaceExtractorInterface $namespaceExtractor;

    private FileCompiler $fileCompiler;

    public function __construct(
        NamespaceExtractorInterface $namespaceExtractor,
        FileCompiler $fileCompiler
    ) {
        $this->namespaceExtractor = $namespaceExtractor;
        $this->fileCompiler = $fileCompiler;
    }

    /**
     * @return list<CompiledFile>
     */
    public function compileProject(array $srcDirectories, string $dest): array
    {
        $namespaceInformation = $this->namespaceExtractor->getNamespacesFromDirectories($srcDirectories);

        $result = [];
        foreach ($namespaceInformation as $info) {
            $targetFile = $dest . '/' . $this->getTargetFileFromNamespace($info->getNamespace());
            $targetDir = dirname($targetFile);
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $result[] = $this->fileCompiler->compileFile($info->getFile(), $targetFile);
        }

        return $result;
    }

    private function getTargetFileFromNamespace(string $namespace): string
    {
        return implode(DIRECTORY_SEPARATOR, explode('\\', $namespace)) . '.php';
    }
}