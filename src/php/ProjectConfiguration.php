<?php

declare(strict_types=1);

namespace Phel;

use JsonSerializable;
use Phel\Command\CommandConfig;
use Phel\Interop\InteropConfig;

final class ProjectConfiguration implements JsonSerializable
{
    private array $testsDirectories = [];
    private array $exportDirectories = [];
    private string $exportNamespacePrefix = '';
    private string $exportTargetDirectory = '';

    /**
     * @param string|array $directories
     */
    public function setTestsDirectories($directories): self
    {
        if (is_string($directories)) {
            $directories = [$directories];
        }

        $this->testsDirectories = $directories;

        return $this;
    }

    /**
     * @param string|array $directories
     */
    public function setExportDirectories($directories): self
    {
        if (is_string($directories)) {
            $directories = [$directories];
        }

        $this->exportDirectories = $directories;

        return $this;
    }

    public function setExportNamespacePrefix(string $string): self
    {
        $this->exportNamespacePrefix = $string;

        return $this;
    }

    public function setExportTargetDirectory(string $string): self
    {
        $this->exportTargetDirectory = $string;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            CommandConfig::TESTS => $this->testsDirectories,
            InteropConfig::EXPORT => [
                InteropConfig::EXPORT_DIRECTORIES => $this->exportDirectories,
                InteropConfig::EXPORT_NAMESPACE_PREFIX => $this->exportNamespacePrefix,
                InteropConfig::EXPORT_TARGET_DIRECTORY => $this->exportTargetDirectory,
            ],
        ];
    }
}
